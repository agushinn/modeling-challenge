<?php

namespace App\Entities\Units;

use App\Entities\Units\Unit;

class Knight extends Unit
{
    const TYPE = "knight";
    const BASE_STRENGTH = 20;
    const TRAINING_INCREASE = 10;
    const TRAINING_COST = 30;
    const TRANSFORMATION_COST = null;

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
