<?php

namespace ACFP\ATR\Updates;

use ACFP\ATR\Models\Site;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('acfp_atr_sites', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->string('name');
            $table->string('code');
            $table->string('timezone');
        });

        Site::insert([
            [
                'region_id' => 4,
                'name'      => 'Moose Jaw',
                'code'      => 'moosejaw',
                'timezone'  => 'America/Regina',
            ],
            [
                'region_id' => 3,
                'name'      => 'Markham',
                'code'      => 'markham',
                'timezone'  => 'America/Toronto',
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('acfp_atr_sites');
    }
};
