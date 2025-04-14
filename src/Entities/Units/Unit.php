<?php

namespace App\Entities\Units;

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

    public function increaseStrength(int $points): void
    {
        $this->strength += $points;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function setStrength(int $strength)
    {
        $this->strength = $strength;
    }

    abstract protected function getBaseStrength();
    abstract public function getTrainingIncrease();
    abstract public function getTrainingCost();
    abstract public function getType();
}
