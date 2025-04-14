<?php

namespace App\Entities\Units;

abstract class Unit
{
    const PIKEMAN = "pikeman";
    const ARCHER = "archer";
    const KNIGHT = "knight";

    protected int $strength;

    public function __construct()
    {
        $this->strength = $this->getBaseStrength();
    }

    public function increaseStrength(int $points): void
    {
        $this->strength += $points;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): void
    {
        if ($strength < 0) {
            throw new \InvalidArgumentException("Strength cannot be negative");
        }
        $this->strength = $strength;
    }

    abstract protected function getBaseStrength(): int;
    abstract public function getTrainingIncrease(): int;
    abstract public function getTrainingCost(): int;
    abstract public function getType(): string;
}
