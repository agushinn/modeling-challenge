<?php

namespace App\Services;

use App\Entities\Army;
use App\Entities\Units\Unit;
use Exception;

class UnitTrainingService
{
    public function train(Unit $unit, Army $army): void
    {
        $cost = $unit->getTrainingCost();
        if ($army->getGold() < $cost) {
            throw new Exception("Not enough gold to train this unit.");
        }
        $army->setGold($army->getGold() - $cost);
        $unit->increaseStrength($unit->getTrainingIncrease());
    }
}
