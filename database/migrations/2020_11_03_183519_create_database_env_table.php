<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Pdmfc\DatabaseEnv\DatabaseEnvModel;

class CreateDatabaseEnvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('database-env', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('key')->unique();
            $table->string('value');
            $table->string('type')->default(DatabaseEnvModel::STRING);
            $table->boolean('subscribe')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('database-env');
    }
}
