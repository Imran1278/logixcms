<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a header setting by key with a fallback default.
     */
    public static function getByKey(string $key, ?string $default = null): ?string
    {
        return self::where('key', $key)->value('value') ?? $default;
    }
}