<?php

namespace App\Interfaces;

use App\Entities\Units\Unit;

interface ArmyInterface
{
    public function getArmyName();
    public function getGold();
    public function setGold($gold);
    public function addUnit(Unit $unit);
    public function getHistoryBattles();
    public function getUnits();
    public function getTotalStrength();
    public function addHistoryBattle($battle);
    public function getHistoryBattleByEnemyArmy($enemyArmyName);
    public function removeUnit(Unit $unit);
}
