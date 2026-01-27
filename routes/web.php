<?php

use App\Http\Controllers\RadarController;
use App\Models\Game;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $user = auth()->user();
    // Don't auto-select game_id = 1 (default) - treat it as no selection
    // Only send selectedGameId if user has explicitly selected a game (not the default)
    $selectedGameId = ($user->game_id && $user->game_id != 1) ? $user->game_id : null;
    
    return Inertia::render('Dashboard', [
        'games' => Game::all()->map(fn ($g) => [
            'id'         => $g->id,
            'name'       => $g->name,
            'price'      => $g->price,
            'image'      => $g->image_path,
            'progress'   => $g->progressFor($user),
            'is_enabled' => (bool) $g->is_enabled, // 👈 add this
        ]),
        'selectedGameId'  => $selectedGameId,
        'wallet_balance'  => (int) $user->wallet_balance,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get ('/radar/status',  [RadarController::class,'status']);
Route::get('/winners', function () {
    return \App\Models\Winner::select('game_name', 'user_name')->get();
});
require __DIR__.'/auth.php';

