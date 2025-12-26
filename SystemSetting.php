<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = ['key','value'];
    public $casts = ['value' => 'json'];
    public $timestamps = false;

    /** static sugar */
    public static function get($key, $default = null)
    {
        return static::query()->where('key',$key)->value('value') ?? $default;
    }

    public static function put($key, $value): void
    {
        static::updateOrCreate(['key'=>$key], ['value'=>$value]);
    }
}
