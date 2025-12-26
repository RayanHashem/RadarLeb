<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Game::all()->map(fn ($g) => [
            'id'        => $g->id,
            'name'      => $g->name,
            'price'     => $g->price,
            'image'     => $g->image_path,
            'progress'  => $g->progressFor(auth()->user()),
        ]);
    }

    /** POST /api/games/{game}/scan */
    public function scan(Game $game)
    {
        return response()->json(
            $game->attemptScan(auth()->user()),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
