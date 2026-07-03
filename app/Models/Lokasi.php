<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';

    protected $fillable = [
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius'
    ];

    public function jarakDari(float $lat, float $lng): float
    {
        $earthRadius = 6371000;

        $latFrom = deg2rad($this->latitude);
        $lngFrom = deg2rad($this->longitude);
        $latTo = deg2rad($lat);
        $lngTo = deg2rad($lng);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $a =
            sin($latDelta / 2) ** 2 +
            cos($latFrom) *
            cos($latTo) *
            sin($lngDelta / 2) ** 2;

        $c = 2 * atan2(
            sqrt($a),
            sqrt(1 - $a)
        );

        return $earthRadius * $c;
    }

    public function isDalamRadius(
        float $lat,
        float $lng
    ): bool {
        return $this->jarakDari(
            $lat,
            $lng
        ) <= $this->radius;
    }

    public static function cariLokasiValid(
        float $lat,
        float $lng
    ): ?self {
        return static::all()
            ->first(
                fn($lokasi) =>
                $lokasi->isDalamRadius(
                    $lat,
                    $lng
                )
            );
    }
}	