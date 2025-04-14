<?php

namespace App\Interfaces;

use App\Entities\Units\Unit;

interface ArmyInterface
{
    public function getArmyName(): string;
    public function getGold(): int;
    public function setGold(int $gold): void;
    public function addUnit(Unit $unit): void;
    public function getHistoryBattles(): array;
    public function getUnits(): array;
    public function getTotalStrength(): int;
    public function addHistoryBattle(array $battle): void;
    public function getHistoryBattleByEnemyArmy(string $enemyArmyName): ?array;
    public function removeUnit(Unit $unit): void;
}
