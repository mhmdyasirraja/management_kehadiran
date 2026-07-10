<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = ['key', 'value'];

    /**
     * Ambil satu nilai pengaturan berdasarkan key, dengan default kalau belum ada.
     */
    public static function get(string $key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Simpan/update nilai pengaturan.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}