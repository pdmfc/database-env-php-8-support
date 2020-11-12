<?php

namespace Pdmfc\DatabaseEnv;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Jackiedo\DotenvEditor\DotenvEditor as Editor;

class DatabaseEnvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database-env:add {keyPair} {y?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert .env variables to database Environment';

    /**
     * @var Editor
     */
    private Editor $dotEnv;

    /**
     * @var array
     */
    private $dotEnvKeys;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dotEnv = DotenvEditor::load();
        $this->dotEnvKeys = $this->dotEnv->getKeys();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $keyValuePair = $this->argument('keyPair') ?? $this->ask('What is KEY=value?');
        $allYes = $this->argument('y');

        try {
            [$name, $value] = explode('=', $keyValuePair);
        }catch(\Exception $e) {
            $this->error('[Error] KEY=value expected!');
            return false;
        }

        $subscribe = $allYes ?? $this->choice('Subscribe if exists in .env?', ['y' => 'yes', 'n' => 'no'], 'y');
        $type = $this->getType($value);

        $configNames = $this->searchInConfig($name);

        if(count($configNames) === 0) {
            $this->error('[Error] KEY not exists in config files!');
            return false;
        }

        $this->info('Current value: ' . config($configNames[0]));
        $add = $allYes ?? $this->choice('Current value is correct?', ['y' => 'yes', 'n' => 'no']);

        if($add === 'n') {
            $this->error('[ABORT] Value is not correct!');
            return false;
        }

        foreach ($configNames as $config) {
            $dbEnv = DatabaseEnvModel::firstOrNew(
                [
                    'key'       => $config
                ],
                [
                    'key'       => $config,
                    'name'      => $name,
                    'value'     => $value,
                    'type'      => $type,
                    'subscribe' => $subscribe === 'y' ? 1 : 0
                ]
            );
            $dbEnv->save();
        }

        $this->clearKey($name);

        $this->info('Key added to Database Environment');
    }

    private function clearKey($key)
    {
        $this->dotEnv->setKey($key);
        $this->dotEnv->save();
    }

    private function searchInConfig($key)
    {
        $found = [];
        $files = File::allFiles('./config');
        foreach ($files  as $file) {
            $lines = file($file->getPathname());
            foreach($lines as $line)
            {
                if(strpos($line, $key) !== false)
                {
                    $configFile = str_replace('.php', '', $file->getFilename());
                    $configKey = str_replace("'", '', explode('=>', trim($line)));
                    $found[] = $this->formatOutput($configFile, trim($configKey[0]));
                }
            }
        }
        return $found;
    }

    private function formatOutput($configFile, $key)
    {
        $path = $this->getPath([$configFile], $configFile, $key);
        return count($path) > 0 ? $path[0] : null;
    }

    private function getPath($path, $configFile, $key, $arrayKey = null)
    {
        $arr = [];
        $configKeys = array_keys(config($configFile));
        foreach($configKeys as $configKey) {
            if(is_array(config($configFile . '.' . $configKey))) {
                $arr[$configKey] = $this->getPath($path, $configFile . '.' . $configKey, $key, $configKey);
            }else {
                if($configKey === $key) {
                    $arr[$configKey] = $configFile . '.' . $configKey;
                }else {
                    unset($arr[$configKey]);
                }
            }

        }

        return collect($arr)->flatten();
    }

    private function recursiveFind(array $haystack, $needle)
    {
        $iterator  = new RecursiveArrayIterator($haystack);
        $recursive = new RecursiveIteratorIterator(
            $iterator,
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($recursive as $key => $value) {
            if ($key === $needle) {
                return $value;
            }
        }
    }

    private function getType($value)
    {
        switch ($value) {
            case is_int($value):
                return DatabaseEnvModel::INTEGER;
                break;
            case $value === 'true' || $value === 'false':
                return DatabaseEnvModel::BOOL;
                break;
            default:
                return DatabaseEnvModel::STRING;
                break;
        }
    }
}
