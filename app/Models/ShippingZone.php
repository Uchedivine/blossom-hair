<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name', 'states', 'rate', 'estimated_days', 'is_active'
    ];

    protected $casts = [
        'states'    => 'array',
        'rate'      => 'decimal:2',
        'is_active' => 'boolean',
    ];

 public static function getRateForState(string $state): ?self
{
    $zones = self::where('is_active', true)->get();

    foreach ($zones as $zone) {
        if (in_array($state, $zone->states)) {
            return $zone;
        }
    }

    return null;
}
}