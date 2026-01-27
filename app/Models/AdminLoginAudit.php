<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminLoginAudit extends Model
{
    protected $fillable = [
        'email_entered',
        'user_id',
        'ip_address',
        'user_agent',
        'success',
        'failure_reason',
        'logged_in_at',
    ];

    protected $casts = [
        'success' => 'boolean',
        'logged_in_at' => 'datetime',
    ];

    /**
     * Get the user associated with this login attempt (if successful).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get successful logins.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('success', true);
    }

    /**
     * Scope to get failed logins.
     */
    public function scopeFailed($query)
    {
        return $query->where('success', false);
    }
}
