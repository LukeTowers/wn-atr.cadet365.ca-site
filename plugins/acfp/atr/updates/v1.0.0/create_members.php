<?php

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('acfp_atr_members', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('site_id')->unsigned()->nullable();
            $table->string('surname');
            $table->string('given_names');
            $table->string('type');
            $table->string('element')->default('air');
            $table->string('rank')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->mediumtext('contact_data')->nullable();
            $table->mediumtext('sensitive_data')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('archived_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('acfp_atr_members');
    }
};
