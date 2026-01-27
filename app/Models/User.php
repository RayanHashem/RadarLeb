<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use App\Models\AdminPreApprovedUser;
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Determine if the user can access the Filament admin panel.
     * 
     * Strict check: User must have:
     * 1. is_admin = true
     * 2. Email must be pre-approved in admin_pre_approved_users table
     * 
     * This is checked by Filament's Authenticate middleware on every request.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // First check: User must have is_admin = true
        if ($this->is_admin !== true) {
            return false;
        }

        // Second check: Email must be pre-approved
        if (! AdminPreApprovedUser::isApproved($this->email)) {
            return false;
        }

        return true;
    }

    public function scans()  { return $this->hasMany(Scan::class); }
    public function gameStats() { return $this->hasMany(GameUserStat::class); }
}
