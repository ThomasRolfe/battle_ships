<?php


namespace App\Services\Combat;


use App\Contracts\Vehicle;
use Exception;

class CombatService
{
    public static function attack(Vehicle $vehicle1, Vehicle $vehicle2, array $impactTypes = null)
    {
        try {

            if(!self::vehiclesCanFight($vehicle1, $vehicle2)) {
                throw new Exception('One or more of the vehicles are unable to fight');
            }

            $baseDamage = self::baseDamage($vehicle1->attack, $vehicle2->defence);

            $impactType = self::impactType($impactTypes ? $impactTypes : $vehicle1::DEFAULT_IMPACTS);

            $resultingDamage = self::resultingDamage($baseDamage, $impactType['multiplier']);

            self::inflictDamage($vehicle2, $resultingDamage);

            return ['impact' => $impactType, 'resulting_damage' => $resultingDamage];

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Check if both vehicles are in a state eligible to fight
     * @param Vehicle $vehicle1
     * @param Vehicle $vehicle2
     * @throws Exception
     */
    public static function vehiclesCanFight(Vehicle $vehicle1, Vehicle $vehicle2)
    {
        if (!$vehicle1->canFight() || !$vehicle2->canFight()) {
            return false;
        }

        return true;
    }


    /**
     * Defence value will protect for half that amount of health, eg. 10 defence points protects 5 health
     * @param int $attack
     * @param int $defence
     * @return int|mixed
     */
    public static function baseDamage(int $attack, int $defence)
    {
        if($attack <= 0) {
            return 0;
        }

        $defended_health = round($defence / 2, 0, PHP_ROUND_HALF_UP);

        // Base damage cannot be a negative number, this would be healing!
        return max($attack - $defended_health, 0);
    }

    /**
     * Uses random number against provided probabilities to decide impact type
     * @param array $availableTypes
     * @return array
     * @throws Exception
     */
    public static function impactType(array $availableTypes): array
    {
        // TODO: check available types are valid format (all values add up to 100)
        $random_number = rand(0, 100);

        $currentProbabilityFloor = 0;
        $currentProbabilityCeiling = 0;

        // Loop through impact types checking random number against the current probability window
        foreach ($availableTypes as $availableType) {
            $currentProbabilityCeiling += $availableType['chance'];

            if ($random_number >= $currentProbabilityFloor && $random_number <= $currentProbabilityCeiling) {
                return $availableType;
            }

            $currentProbabilityFloor += $availableType['chance'];
        }

        throw new Exception('No available types matched in range');

    }


    /**
     * @param int $baseDamage
     * @param float $multiplier
     * @return int
     */
    public static function resultingDamage(int $baseDamage, float $multiplier): int
    {
        return round($baseDamage * $multiplier, 0, PHP_ROUND_HALF_UP);
    }

    /**
     * Removes damage value from vehicle health. Health cannot go below zero
     * @param Vehicle $vehicle
     * @param int $damage
     * @return Vehicle
     */
    public static function inflictDamage(Vehicle $vehicle, int $damage): Vehicle
    {
        $vehicle->health = max($vehicle->health - $damage, 0);
        return $vehicle;
    }

}

