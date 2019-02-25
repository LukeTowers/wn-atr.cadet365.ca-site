<?php namespace ACGP\FlyingSite\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePenForms extends Migration
{
    public function up()
    {
        Schema::create('acgp_flyingsite_pen_forms', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->mediumtext('sensitive_data')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('acgp_flyingsite_pen_forms');
    }
}
