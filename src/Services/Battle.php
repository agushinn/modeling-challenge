<?php

namespace App\Services;

use App\Entities\Army;
use App\Strategies\SortMostPowerfulUnitsStrategy;

class Battle
{

    const BATTLE_RESULT_WIN = "win";
    const BATTLE_RESULT_LOSE = "lose";
    const BATTLE_RESULT_DRAW = "draw";

    public function fight(Army $army1, Army $army2): ?bool
    {
        $strength1 = $army1->getTotalStrength();
        $strength2 = $army2->getTotalStrength();

        // Determinate winner and loser based on total strength
        if ($strength1 > $strength2) {
            $result1 = self::BATTLE_RESULT_WIN;
            $result2 = self::BATTLE_RESULT_LOSE;
            $winner = $army1;
            $loser = $army2;
        } elseif ($strength1 < $strength2) {
            $result1 = self::BATTLE_RESULT_LOSE;
            $result2 = self::BATTLE_RESULT_WIN;
            $winner = $army2;
            $loser = $army1;
        } else {
            $result1 = self::BATTLE_RESULT_DRAW;
            $result2 = self::BATTLE_RESULT_DRAW;
            $army1->addHistoryBattle(['enemyArmyName' => $army2->getArmyName(), 'result' => $result1]);
            $army2->addHistoryBattle(['enemyArmyName' => $army1->getArmyName(), 'result' => $result2]);
            return null;
        }

        // Register the result in the battle history
        $army1->addHistoryBattle(['enemyArmyName' => $army2->getArmyName(), 'result' => $result1]);
        $army2->addHistoryBattle(['enemyArmyName' => $army1->getArmyName(), 'result' => $result2]);

        // Update the gold of the winner
        $winner->setGold($winner->getGold() + 100);

        // Remove the most powerful units from the loser
        $unitsToRemove = (new SortMostPowerfulUnitsStrategy())->findMostPowerfulUnits($loser->getUnits());
        foreach ($unitsToRemove as $unit) {
            $loser->removeUnit($unit);
        }

        return $winner === $army1;
    }
}
