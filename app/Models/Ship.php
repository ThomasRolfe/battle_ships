<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    protected $fillable = [
        'health',
        'attack',
        'defence'
    ];

    public const DEFAULT_IMPACTS = [
        [
            'name' => 'miss',
            'chance' => 25,
            'multiplier' => 0

        ],
        [
            'name' => 'lucky_shot',
            'weight' => 10,
            'multiplier' => 3
        ],
        [
            'name' => 'hit',
            'weight' => 65,
            'multiplier' => 1
        ],
    ];

}
