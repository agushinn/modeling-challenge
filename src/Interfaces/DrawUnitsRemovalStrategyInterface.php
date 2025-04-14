<?php

namespace App\Interfaces;

interface DrawUnitsRemovalStrategyInterface
{
    public function selectUnits(array $units, int $count): array;
}
