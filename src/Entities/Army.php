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

    public function __construct(string $armyName)
    {
        $this->armyName = $armyName;
    }

    public function getArmyName(): string
    {
        return $this->armyName;
    }

    public function getGold(): int
    {
        return $this->gold;
    }

    public function setGold(int $gold): void
    {
        if ($gold < 0) {
            throw new \InvalidArgumentException("Gold cannot be negative");
        }
        $this->gold = $gold;
    }

    public function getUnits(): array
    {
        return $this->units;
    }

    public function addUnit(Unit $unit): void
    {
        $this->units[] = $unit;
    }

    public function removeUnit(Unit $unit): void
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

    public function getTotalStrength(): int
    {
        $totalStrength = 0;
        foreach ($this->units as $unit) {
            $totalStrength += $unit->getStrength();
        }
        return $totalStrength;
    }

    public function getHistoryBattles(): array
    {
        return $this->historyBattles;
    }

    public function addHistoryBattle(array $battle): void
    {
        $this->historyBattles[] = $battle;
    }

    public function getHistoryBattleByEnemyArmy($enemyArmyName): ?array
    {
        foreach ($this->historyBattles as $battle) {
            if ($battle['enemyArmyName'] == $enemyArmyName) {
                return $battle;
            }
        }
        return null;
    }
}
