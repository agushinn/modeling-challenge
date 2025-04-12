<?php

namespace App\Interfaces;

interface MostPowerfulUnitsStrategyInterface
{
    public function findMostPowerfulUnits(array $units): array;
}
