<?php

namespace App\Entities\Units;

use App\Entities\Units\Unit;

class Pikeman extends Unit
{
    const TYPE = "pikeman";
    const BASE_STRENGTH = 5;
    const TRAINING_INCREASE = 3;
    const TRAINING_COST = 10;
    const TRANSFORMATION_COST = 30;

    public function getType(): string
    {
        return self::TYPE;
    }

    protected function getBaseStrength(): int
    {
        return self::BASE_STRENGTH;
    }

    public function getTrainingIncrease(): int
    {
        return self::TRAINING_INCREASE;
    }

    public function getTrainingCost(): int
    {
        return self::TRAINING_COST;
    }
}
