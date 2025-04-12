<?php

namespace App\Strategies;

use App\Interfaces\MostPowerfulUnitsStrategyInterface;

class SortMostPowerfulUnitsStrategy implements MostPowerfulUnitsStrategyInterface
{
    public function findMostPowerfulUnits(array $units): array
    {
        if (count($units) < 2) {
            return $units;
        }
        usort($units, function ($a, $b) {
            return $b->getStrength() <=> $a->getStrength();
        });
        return array_slice($units, 0, 2);
    }
}
