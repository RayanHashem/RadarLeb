<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameUserStat extends Model
{
    protected $fillable = ['user_id','game_id','current_radar','failed_scans','successful_scans','amount_spent'];

    public function user() { return $this->belongsTo(User::class); }
    public function game() { return $this->belongsTo(Game::class); }
}
