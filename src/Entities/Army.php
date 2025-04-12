<?php

namespace App\Entities;

use App\Entities\Units\Unit;
use App\Interfaces\ArmyInterface;

class Army implements ArmyInterface
{
    private $armyName;
    private $units = [];
    private $gold = 1000;
    private $historyBattles = [];

    public function __construct($armyName)
    {
        $this->armyName = $armyName;
    }

    public function getArmyName()
    {
        return $this->armyName;
    }

    public function getGold()
    {
        return $this->gold;
    }

    public function setGold($gold)
    {
        $this->gold = $gold;
    }

    public function getUnits()
    {
        return $this->units;
    }

    public function addUnit(Unit $unit)
    {
        $this->units[] = $unit;
    }

    public function removeUnit(Unit $unit)
    {
        foreach ($this->units as $key => $existingUnit) {
            if ($existingUnit === $unit) {
                unset($this->units[$key]);
                // Re index array to maintain sequential keys
                $this->units = array_values($this->units);
                return;
            }
        }
    }

    public function getTotalStrength()
    {
        $totalStrength = 0;
        foreach ($this->units as $unit) {
            $totalStrength += $unit->getStrength();
        }
        return $totalStrength;
    }

    public function getHistoryBattles()
    {
        return $this->historyBattles;
    }

    public function addHistoryBattle($battle)
    {
        $this->historyBattles[] = $battle;
    }

    public function getHistoryBattleByEnemyArmy($enemyArmyName)
    {
        foreach ($this->historyBattles as $battle) {
            if ($battle['enemyArmyName'] == $enemyArmyName) {
                return $battle;
            }
        }
        return null;
    }
}
