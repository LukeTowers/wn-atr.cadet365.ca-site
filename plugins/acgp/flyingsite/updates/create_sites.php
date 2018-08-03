<?php namespace ACGP\FlyingSite\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use ACGP\FlyingSite\Models\Site as SiteModel;

class CreateSites extends Migration
{
    public function up()
    {
        Schema::create('acgp_flyingsite_sites', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->string('name');
            $table->string('code');
            $table->string('timezone');
        });

        SiteModel::insert([
            [
                'region_id' => 4,
                'name'      => 'Moose Jaw',
                'code'      => 'moosejaw',
                'timezone'  => 'America/Regina',
            ],
            [
                'region_id' => 2,
                'name'      => 'Markham',
                'code'      => 'markham',
                'timezone'  => 'America/Toronto',
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('acgp_flyingsite_sites');
    }
}
