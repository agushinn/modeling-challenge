<?php

namespace App\Entities\Units;

use App\Entities\Units\Unit;
use App\Entities\Army;
use Exception;

class Knight extends Unit
{
    const TYPE = "knight";
    const BASE_STRENGTH = 20;
    const TRAINING_INCREASE = 10;
    const TRAINING_COST = 30;
    const TRANSFORMATION_COST = null;

    public function getType()
    {
        return self::TYPE;
    }

    protected function getBaseStrength()
    {
        return self::BASE_STRENGTH;
    }

    protected function getTrainingIncrease()
    {
        return self::TRAINING_INCREASE;
    }

    protected function getTrainingCost()
    {
        return self::TRAINING_COST;
    }

    // Knight cannot be transformed to another unit.
    public function transform(Army $army)
    {
        throw new Exception("Knight cannot be transformed.");
    }
}
