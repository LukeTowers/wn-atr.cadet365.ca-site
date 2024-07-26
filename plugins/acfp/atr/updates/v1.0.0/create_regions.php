<?php

use ACFP\ATR\Models\Region;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('acfp_atr_regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->string('code')->unique();
            $table->mediumText('metadata')->nullable();
            $table->timestamps();
        });

        $now = now();
        Region::insert([
            [
                'name' => 'Atlantic',
                'short_name' => 'RCSU (A)',
                'code' => 'ATL',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Eastern',
                'short_name' => 'RCSU (E)',
                'code' => 'EST',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Central',
                'short_name' => 'RCSU (C)',
                'code' => 'CEN',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Northwest',
                'short_name' => 'RCSU (NW)',
                'code' => 'NW',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pacific',
                'short_name' => 'RCSU (P)',
                'code' => 'PAC',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('acfp_atr_regions');
    }
};
