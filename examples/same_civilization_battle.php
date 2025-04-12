<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Entities\Civilization;
use App\Entities\Units\Unit;
use App\Services\Battle;


echo " ------------------ BATTLE BETWEEN TWO ARMIES OF THE SAME CIVILIZATION ---------------------- " . PHP_EOL;
try {

    echo "CHINE vs CHINE";

    echo "STAGE 1: CREATE CIVILIZATION" . PHP_EOL;
    $civilizationChine = new Civilization("Chinese");

    echo "STAGE 2: CREATE ARMY" . PHP_EOL;
    $civilizationChine->createArmy("chinese first army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 2],
        ['type' => Unit::ARCHER, 'quantity' => 25],
        ['type' => Unit::KNIGHT, 'quantity' => 2]
    ]);

    $civilizationChine->createArmy("chinese second army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 40],
        ['type' => Unit::ARCHER, 'quantity' => 25],
        ['type' => Unit::KNIGHT, 'quantity' => 2]
    ]);

    echo "STAGE 3: SHOW ARMY STRENGTH" . PHP_EOL;
    $allArmiesChinese = $civilizationChine->getAllArmies();
    foreach ($allArmiesChinese as $armyName => $army) {
        echo "-------------------" . $armyName . "-------------------" . PHP_EOL;
        echo "Army: " . $armyName . " - Strength: " . $army->getTotalStrength() . PHP_EOL;
        foreach ($army->getUnits() as $unit) {
            echo "Army: " . $armyName . " { Unit Type: " . $unit->getType() . " - Strength: " . $unit->getStrength() . " }" . PHP_EOL;
        }
    }

    echo "STAGE 4: BATTLE CHINE VS CHINE" . PHP_EOL;
    $battle = new Battle();
    $battle->fight($allArmiesChinese['chinese-first-army'], $allArmiesChinese['chinese-second-army']);

    echo "STAGE 5: SHOW CHINESE BATTLE HISTORY" . PHP_EOL;
    $historyChinese = $allArmiesChinese['chinese-first-army']->getHistoryBattles();
    foreach ($historyChinese as $battle) {
        echo "Battle against: " . $battle['enemyArmyName'] . " - Result: " . $battle['result'] . PHP_EOL;
    }

    echo "STAGE 6: SHOW CHINESE BATTLE HISTORY" . PHP_EOL;
    $historyChinese = $allArmiesChinese['chinese-second-army']->getHistoryBattles();
    foreach ($historyChinese as $battle) {
        echo "Battle against: " . $battle['enemyArmyName'] . " - Result: " . $battle['result'] . PHP_EOL;
    }

    echo "STAGE 7: SHOW ARMYS AND GOLD AFTER BATTLE" . PHP_EOL;
    echo "Army: " . $allArmiesChinese['chinese-first-army']->getArmyName() . " - Gold: " . $allArmiesChinese['chinese-first-army']->getGold() . PHP_EOL;
    echo "Army: " . $allArmiesChinese['chinese-second-army']->getArmyName() . " - Gold: " . $allArmiesChinese['chinese-second-army']->getGold() . PHP_EOL;

    echo "STAGE 8: SHOW ARMYS AND GOLD AFTER BATTLE" . PHP_EOL;
    foreach ($allArmiesChinese as $armyName => $army) {
        foreach ($army->getUnits() as $unit) {
            echo "Army: " . $armyName . " { Unit Type: " . $unit->getType() . " - Strength: " . $unit->getStrength() . " }" . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
