<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CombatTest extends TestCase
{

    public function test_both_vehicles_with_health_are_able_to_fight()
    {

        $shipA = factory(\App\Models\Ship::class)->make();
        $shipB = factory(\App\Models\Ship::class)->make();

        $this->assertTrue(\App\Services\Combat\CombatService::vehiclesCanFight($shipA, $shipB));

    }

    public function test_one_vehicle_without_health_is_unable_to_fight()
    {

        $shipA = factory(\App\Models\Ship::class)->make();
        $shipB = factory(\App\Models\Ship::class)->make();

        $shipA->health = 0;

        $this->assertFalse(\App\Services\Combat\CombatService::vehiclesCanFight($shipA, $shipB));

    }

    public function test_base_damage_values_correct()
    {
        $damage = \App\Services\Combat\CombatService::baseDamage(20, 10);
        $this->assertEquals(15, $damage);
    }

    public function test_negative_attack_damage_returns_zero()
    {
        $damage = \App\Services\Combat\CombatService::baseDamage(5, 20);
        $this->assertEquals(0, $damage);
    }

    public function test_zero_attack_damage_returns_zero()
    {
        $damage = \App\Services\Combat\CombatService::baseDamage(0, 20);
        $this->assertEquals(0, $damage);
    }

    public function test_resulting_damage_rounds_up()
    {
        $damage = \App\Services\Combat\CombatService::resultingDamage(5, 0.5);
        $this->assertEquals(3, $damage);
    }

    public function test_base_damage_rounds_up()
    {
        $damage = \App\Services\Combat\CombatService::baseDamage(10, 5);
        $this->assertEquals(7, $damage);
    }
}
