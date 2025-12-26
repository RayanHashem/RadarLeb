<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = ['user_id','game_id','success','radar_level','cost'];

    public function user() { return $this->belongsTo(User::class); }
    public function game() { return $this->belongsTo(Game::class); }
}
