<?php

namespace App\Strategies;

use App\Interfaces\MostPowerfulUnitsStrategyInterface;

class IterativeMostPowerfulUnitsStrategy implements MostPowerfulUnitsStrategyInterface
{
    public function findMostPowerfulUnits(array $units): array
    {
        if (count($units) < 2) {
            return $units;
        }
        $first = null;
        $second = null;
        foreach ($units as $unit) {
            if ($first === null || $unit->getStrength() > $first->getStrength()) {
                $second = $first;
                $first = $unit;
            } elseif ($second === null || $unit->getStrength() > $second->getStrength()) {
                $second = $unit;
            }
        }
        $result = [];
        if ($first !== null) {
            $result[] = $first;
        }
        if ($second !== null) {
            $result[] = $second;
        }
        return $result;
    }
}
