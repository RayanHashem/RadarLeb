<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->json('value');
            $t->timestamps();
        });

        // default: scans ON
        DB::table('system_settings')->insert([
            'key'   => 'scans_enabled',
            'value' => json_encode(true),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
