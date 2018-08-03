<?php namespace ACGP\FlyingSite\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMembers extends Migration
{
    public function up()
    {
        Schema::create('acgp_flyingsite_members', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('site_id')->unsigned()->nullable();
            $table->string('surname');
            $table->string('given_names');
            $table->string('type');
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
        Schema::dropIfExists('acgp_flyingsite_members');
    }
}
