<?php


namespace App\Contracts;


interface Vehicle
{
    /**
     * Check Vehicle conditions for state that allows vehicle to fight
     * @return bool
     */
    public function canFight() : bool;
    public const DEFAULT_IMPACTS = [
        [
            'name' => 'miss',
            'chance' => 25,
            'multiplier' => 0
        ],
        [
            'name' => 'lucky_shot',
            'chance' => 10,
            'multiplier' => 3
        ],
        [
            'name' => 'hit',
            'chance' => 65,
            'multiplier' => 1
        ],
    ];
}
