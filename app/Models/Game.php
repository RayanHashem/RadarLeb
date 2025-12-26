<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['name','price','image_path','price_to_play','minimum_amount_for_winning','is_enabled','draw_number'];

    public function scans()      { return $this->hasMany(Scan::class); }
    public function stats()      { return $this->hasMany(GameUserStat::class); }

    /** Get the logged-in user’s progress (used by API). */
    public function progressFor(User $user): array
    {
        $stat = $this->stats()->firstOrCreate(['user_id'=>$user->id]);
        return [
            'radar_level'   => $stat->current_radar,
            'failed_scans'  => $stat->failed_scans,
            'successful'    => $stat->successful_scans,
            'amount_spent'  => $stat->amount_spent,
            'can_win_final' => $this->canUserWinFinal($user),
        ];
    }

    public function attemptScan(User $user): array
    {
        abort_unless($this->is_enabled == true, 423, 'game_disabled');

        $stat = $this->stats()->firstOrCreate(['user_id' => $user->id]);
        $cost = $this->price_to_play;
        abort_unless(SystemSetting::get('scans_enabled', true), 423, 'Radar offline');

        abort_if($user->wallet_balance < $cost, 402, 'Not enough balance');
        $user->decrement('wallet_balance', $cost);
        $stat->increment('amount_spent', $cost);

        $nextRadar     = min($stat->current_radar + 1, 6);
        $baseFails   = $nextRadar * 10;
        $neededFails = $baseFails + mt_rand(-2, 2);

        $stat->increment('fails_in_level');
        $isSuccess = false;

        if ($stat->fails_in_level >= $neededFails) {
            $isSuccess = (mt_rand(0, 1) === 1);
            if ($isSuccess) {
                $stat->current_radar     = $nextRadar;
                $stat->successful_scans += 1;
                $stat->fails_in_level    = 0;
            }
        }

        if (! $isSuccess) {
            $stat->failed_scans += 1;
        }

        $stat->save();

        $this->scans()->create([
            'user_id'     => $user->id,
            'success'     => $isSuccess,
            'radar_level' => $stat->current_radar,
            'cost'        => $cost,
        ]);

        return [
            'antenna_detected' => $isSuccess,
            'progress'         => $this->progressFor($user),
            'wallet'           => auth()->user()->wallet_balance,
        ];
    }

    protected function canUserWinFinal(User $user): bool
    {
        $totalSpent     = $this->stats()->sum('amount_spent');
        if ($totalSpent < $this->minimum_amount_for_winning) { return false; }

        $topIds = $this->stats()
            ->orderByDesc('amount_spent')
            ->take(3)
            ->pluck('user_id')
            ->all();
        return in_array($user->id, $topIds, true);
    }
}
