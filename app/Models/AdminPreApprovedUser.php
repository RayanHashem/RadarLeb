<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminPreApprovedUser extends Model
{
    protected $fillable = [
        'email',
        'name',
        'notes',
        'is_active',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user who approved this email.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope to get only active approvals.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if an email is pre-approved and active.
     */
    public static function isApproved(string $email): bool
    {
        return static::where('email', $email)
            ->where('is_active', true)
            ->exists();
    }
}
