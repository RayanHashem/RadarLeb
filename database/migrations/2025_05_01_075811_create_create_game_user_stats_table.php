<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_user_stats', function (Blueprint $t) {
            $t->id();
            $t->foreignIdFor(\App\Models\User::class);
            $t->foreignIdFor(\App\Models\Game::class);
            $t->unsignedTinyInteger('current_radar')->default(0);   // 0-6
            $t->unsignedInteger('failed_scans')->default(0);
            $t->unsignedInteger('successful_scans')->default(0);
            $t->decimal('amount_spent', 12, 2)->default(0);
            $t->unsignedInteger('fails_in_level')->default(0);
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_game_user_stats');
    }
};
