<?php namespace ACGP\FlyingSite\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use ACGP\FlyingSite\Models\Region as RegionModel;

class CreateRegions extends Migration
{
    public function up()
    {
        Schema::create('acgp_flyingsite_regions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('code');
        });

        RegionModel::insert([
            [
                'code' => 'atlantic',
                'name' => 'Atlantic'
            ],
            [
                'code' => 'central',
                'name' => 'Central'
            ],
            [
                'code' => 'eastern',
                'name' => 'Eastern',
            ],
            [
                'code' => 'northwest',
                'name' => 'Northwest'
            ],
            [
                'code' => 'pacific',
                'name' => 'Pacific'
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('acgp_flyingsite_regions');
    }
}
