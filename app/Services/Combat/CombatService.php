<?php


namespace App\Services\Combat;


use App\Models\Ship;
use Exception;

class CombatService
{
    public function attack(Ship $vehicle1, Ship $vehicle2, array $impactTypes)
    {
        try {
            // Ensure both vehicles have health to fight
            $this->vehicleCanFight($vehicle1);
            $this->vehicleCanFight($vehicle2);

            $baseDamage = $this->baseDamage($vehicle1->attack, $vehicle2->defence);

            $impactType = $this->impactType($impactTypes);

            $resultingDamage = $this->resultingDamage($baseDamage, $impactType);

            $this->inflictDamage($vehicle2, $resultingDamage);

            return ['impact' => $impactType, 'resulting_damage' => $resultingDamage];

        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }

    public function vehicleCanFight(Ship $vehicle)
    {
        if (!property_exists($vehicle, 'health') || !is_numeric($vehicle->health) || $vehicle->health <= 0) {
            throw new Exception('Vehicle must have more than 0 health to fight');
        }
    }

    public function baseDamage(int $attack, int $defence)
    {
        // Defence value will protect for half of that amount of health, eg. 10 defence protects 5 health
        $defended_health = round($defence / 2, 0, PHP_ROUND_HALF_UP);

        // Base damage cannot be a negative number (no friendly fire)
        return max($attack - $defended_health, 0);
    }

    public function impactType(array $availableTypes)
    {
        // check available types are valid format (all values add up to 100)
        $random_number = rand(0, 100);

        $currentProbabilityFloor = 0;
        $currentProbabilityCeiling = 0;

        foreach ($availableTypes as $availableType) {
            $currentProbabilityCeiling += $availableType['chance'];

            if ($random_number > $currentProbabilityFloor && $random_number <= $currentProbabilityCeiling) {
                return $availableType;
            }

            $currentProbabilityFloor += $availableType['chance'];
        }

        throw new Exception('No available types matched in range');

    }

    public function resultingDamage(int $baseDamage, float $multiplier) {
        return $baseDamage * $multiplier;
    }

    public function inflictDamage(Ship $vehicle, $damage) {
        $vehicle->health = max($vehicle->health - $damage, 0);
        return $vehicle;
    }

}

