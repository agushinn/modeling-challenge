<?php

namespace App\Services;

use App\Entities\Army;
use App\Strategies\SortMostPowerfulUnitsStrategy;
use App\Strategies\RandomUnitsRemovalStrategy;

class BattleService
{

    const BATTLE_RESULT_WIN = "win";
    const BATTLE_RESULT_LOSE = "lose";
    const BATTLE_RESULT_DRAW = "draw";
    const GOLD_REWARD = 100;
    const UNITS_TO_REMOVE_DRAW = 1;

    public function fight(Army $army1, Army $army2): ?bool
    {
        $strength1 = $army1->getTotalStrength();
        $strength2 = $army2->getTotalStrength();

        if ($strength1 > $strength2) {
            return $this->handleVictory($army1, $army2);
        } elseif ($strength1 < $strength2) {
            return $this->handleVictory($army2, $army1);
        } else {
            return $this->handleDraw($army1, $army2);
        }
    }

    private function handleVictory(Army $winner, Army $loser): bool
    {
        $this->registerBattleHistory($winner, $loser, self::BATTLE_RESULT_WIN, self::BATTLE_RESULT_LOSE);
        $this->updateWinnerGold($winner);
        $this->removeMostPowerfulUnitsFromLoser($loser);

        return true;
    }

    private function handleDraw(Army $army1, Army $army2): null
    {
        $this->registerBattleHistory($army1, $army2, self::BATTLE_RESULT_DRAW, self::BATTLE_RESULT_DRAW);
        $this->removeRandomUnits($army1);
        $this->removeRandomUnits($army2);

        return null;
    }

    private function registerBattleHistory(Army $army1, Army $army2, string $result1, string $result2): void
    {
        $army1->addHistoryBattle(['enemyArmyName' => $army2->getArmyName(), 'result' => $result1]);
        $army2->addHistoryBattle(['enemyArmyName' => $army1->getArmyName(), 'result' => $result2]);
    }

    private function updateWinnerGold(Army $winner): void
    {
        $winner->setGold($winner->getGold() + self::GOLD_REWARD);
    }

    private function removeMostPowerfulUnitsFromLoser(Army $loser): void
    {
        $unitsToRemove = (new SortMostPowerfulUnitsStrategy())->findMostPowerfulUnits($loser->getUnits());
        foreach ($unitsToRemove as $unit) {
            $loser->removeUnit($unit);
        }
    }

    private function removeRandomUnits(Army $army): void
    {
        foreach ((new RandomUnitsRemovalStrategy())->selectUnits($army->getUnits(), self::UNITS_TO_REMOVE_DRAW) as $unit) {
            $army->removeUnit($unit);
        }
    }
}
