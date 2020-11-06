<?php

namespace Pdmfc\DatabaseEnv;

class DatabaseEnv
{
    public static function setConfig(): void
    {
        $config_env = DatabaseEnvRepository::all()
            ->keyBy('key')
            ->transform(static function ($setting) {
                return [
                    'value' => self::formatted_env($setting),
                    'subscribe' => $setting->subscribe
                ];
            })
            ->toArray();

        foreach ($config_env as $key => $data) {
            $notExist = config($key) === null || empty(config($key));
            $canSubscribe = $data['subscribe'] === 1 && !$notExist;
            
            if($canSubscribe || $notExist) {
                config([$key => $data['value']]);
            }
        }
    }

    /**
     * Format database environment key from database.
     *
     * @param DatabaseEnvModel $row
     * @return mixed
     */
    private static function formatted_env($row)
    {
        $output = null;
        switch ($row) {
            case $row->type === DatabaseEnvModel::INTEGER:
                $output = (int) $row->value;
                break;
            case $row->type === DatabaseEnvModel::BOOL:
                $output = (bool) $row->value;
                break;
            default:
                $output = $row->value;
        }
        return $output;
    }

}
