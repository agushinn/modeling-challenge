<?php

namespace App\Entities\Units;

use App\Entities\Army;
use Exception;

abstract class Unit
{
    const PIKEMAN = "pikeman";
    const ARCHER = "archer";
    const KNIGHT = "knight";

    protected $strength;

    public function __construct()
    {
        $this->strength = $this->getBaseStrength();
    }

    public function train(Army $army)
    {
        $cost = $this->getTrainingCost();
        if ($army->getGold() < $cost) {
            throw new Exception("Oro insuficiente para entrenar la unidad.");
        }
        $army->setGold($army->getGold() - $cost);
        $this->strength += $this->getTrainingIncrease();
    }

    public function getStrength()
    {
        return $this->strength;
    }

    abstract protected function getBaseStrength();
    abstract protected function getTrainingIncrease();
    abstract protected function getTrainingCost();
    abstract protected function getType();
    abstract public function transform(Army $army);
}
