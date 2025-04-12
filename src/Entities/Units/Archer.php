<?php

namespace App\Entities\Units;

use App\Entities\Units\Knight;
use App\Entities\Units\Unit;
use App\Entities\Army;
use Exception;

class Archer extends Unit
{
    const TYPE = "archer";
    const BASE_STRENGTH = 10;
    const TRAINING_INCREASE = 7;
    const TRAINING_COST = 20;
    const TRANSFORMATION_COST = 20;

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
    // and added to the BASE_STRENGTH of knight. If it was not trained, the base strength of knight is used.
    public function transform(Army $army)
    {
        if ($army->getGold() < self::TRANSFORMATION_COST) {
            throw new Exception("Oro insuficiente para transformar a knight.");
        }
        $army->setGold($army->getGold() - self::TRANSFORMATION_COST);
        $extra = $this->strength - self::BASE_STRENGTH; // Difference accumulated by training (can be 0)
        $bonus = floor($extra / 2);
        $newUnit = new Knight();
        // El nuevo knight tiene su fuerza base más el bonus calculado.
        $newUnit->strength = Knight::BASE_STRENGTH + $bonus;
        return $newUnit;
    }
}
