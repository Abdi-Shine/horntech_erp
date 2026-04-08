<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Retrieve a setting value by key.
     */
    public static function get(string $key, string $default = ''): string
    {
        $row = static::where('key', $key)->first();
        return $row?->value ?? $default;
    }

    /**
     * Store or update a setting value.
     */
    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
