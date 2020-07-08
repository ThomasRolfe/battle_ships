<?php

namespace App\Models;

use App\Contracts\Vehicle;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model implements Vehicle
{
    protected $fillable = [
        'health',
        'attack',
        'defence'
    ];

    public function canFight(): bool
    {
        if($this->health <= 0) {
            return false;
        }

        return true;
    }

}
