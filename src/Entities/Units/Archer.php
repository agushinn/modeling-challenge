<?php

namespace App\Entities\Units;

use App\Entities\Units\Unit;

class Archer extends Unit
{
    const TYPE = "archer";
    const BASE_STRENGTH = 10;
    const TRAINING_INCREASE = 7;
    const TRAINING_COST = 20;
    const TRANSFORMATION_COST = 40;

    public function getType()
    {
        return self::TYPE;
    }

    protected function getBaseStrength()
    {
        return self::BASE_STRENGTH;
    }

    public function getTrainingIncrease()
    {
        return self::TRAINING_INCREASE;
    }

    public function getTrainingCost()
    {
        return self::TRAINING_COST;
    }
}
