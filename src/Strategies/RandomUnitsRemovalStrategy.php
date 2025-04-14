<?php

namespace App\Strategies;

use App\Interfaces\DrawUnitsRemovalStrategyInterface;

class RandomUnitsRemovalStrategy implements DrawUnitsRemovalStrategyInterface
{
    public function selectUnits(array $units, int $count): array
    {
        if (count($units) <= $count) {
            return $units;
        }

        $keys = array_rand($units, $count);
        $selected = [];

        foreach ((array) $keys as $key) {
            $selected[] = $units[$key];
        }

        return $selected;
    }
}
