<?php

namespace App\Entities\Units;

use App\Entities\Army;
use Exception;
use App\Entities\Units\Archer;
use App\Entities\Units\Knight;
use App\Entities\Units\Unit;


class Pikeman extends Unit
{
    const TYPE = "pikeman";
    const BASE_STRENGTH = 5;
    const TRAINING_INCREASE = 3;
    const TRAINING_COST = 10;
    const TRANSFORMATION_COST = 30;

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

    // If the unit was trained, the extra strength is halved (rounded down)
    // and added to the BASE_STRENGTH of Archer. If it was not trained, the base strength of Archer is used.
    public function transform(Army $army)
    {
        if ($army->getGold() < self::TRANSFORMATION_COST) {
            // throw new Exception("Oro insuficiente para transformar a Archer.");
            throw new Exception("Gold insufficient to transform to Archer.");
        }
        $army->setGold($army->getGold() - self::TRANSFORMATION_COST);
        $extra = $this->strength - self::BASE_STRENGTH; // Difference accumulated by training (can be 0)
        $bonus = floor($extra / 2);
        $newUnit = new Archer();

        // New archer has the base strength of Archer plus the bonus calculated.
        $newUnit->strength = Archer::BASE_STRENGTH + $bonus;
        return $newUnit;
    }
}
