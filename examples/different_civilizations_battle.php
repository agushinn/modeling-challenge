<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Entities\Civilization;
use App\Entities\Units\Unit;
use App\Services\Battle;

echo " ------------------ BATTLE BETWEEN ARMIES OF DIFFERENT CIVILIZATIONS ---------------------- " . PHP_EOL;
try {
    echo "STAGE 1: CREATE CIVILIZATION" . PHP_EOL;
    $civilizationChine = new Civilization("Chinese");
    $civilizationEnglish = new Civilization("English");
    $civilizationByzantine = new Civilization("Byzantine");
    echo "New civilization created: " . $civilizationChine->getCivilizationName() . PHP_EOL;
    echo "New civilization created: " . $civilizationEnglish->getCivilizationName() . PHP_EOL;
    echo "New civilization created: " . $civilizationByzantine->getCivilizationName() . PHP_EOL;

    echo "STAGE 2: CREATE ARMY" . PHP_EOL;

    $armyChine = $civilizationChine->createArmy("chinese first army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 2],
        ['type' => Unit::ARCHER, 'quantity' => 25],
        ['type' => Unit::KNIGHT, 'quantity' => 2]
    ]);

    $armyEnglish = $civilizationEnglish->createArmy("ENGLISH FIRST ARMY", [
        ['type' => Unit::PIKEMAN, 'quantity' => 10],
        ['type' => Unit::ARCHER, 'quantity' => 10],
        ['type' => Unit::KNIGHT, 'quantity' => 10]
    ]);

    $armyByzantine = $civilizationByzantine->createArmy("Byzantine First Army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 5],
        ['type' => Unit::ARCHER, 'quantity' => 8],
        ['type' => Unit::KNIGHT, 'quantity' => 15]
    ]);

    $allArmiesChinese = $civilizationChine->getAllArmies();
    foreach ($allArmiesChinese as $armyName => $army) {
        foreach ($army->getUnits() as $unit) {
            echo "Army: " . $armyName . " { Unit Type: " . $unit->getType() . " - Strength: " . $unit->getStrength() . " }" . PHP_EOL;
        }
    }

    $allArmiesEnglish = $civilizationEnglish->getAllArmies();
    foreach ($allArmiesEnglish as $armyName => $army) {
        foreach ($army->getUnits() as $unit) {
            echo "Army: " . $armyName . " { Unit Type: " . $unit->getType() . " - Strength: " . $unit->getStrength() . " }" . PHP_EOL;
        }
    }

    $allArmiesByzantine = $civilizationByzantine->getAllArmies();
    foreach ($allArmiesByzantine as $armyName => $army) {
        foreach ($army->getUnits() as $unit) {
            echo "Army: " . $armyName . " { Unit Type: " . $unit->getType() . " - Strength: " . $unit->getStrength() . " }" . PHP_EOL;
        }
    }

    echo "STAGE 3: SHOW ARMY STRENGTH" . PHP_EOL;
    echo "Army: " . $armyChine->getArmyName() . " - Strength: " . $armyChine->getTotalStrength() . PHP_EOL;
    echo "Army: " . $armyEnglish->getArmyName() . " - Strength: " . $armyEnglish->getTotalStrength() . PHP_EOL;
    echo "Army: " . $armyByzantine->getArmyName() . " - Strength: " . $armyByzantine->getTotalStrength() . PHP_EOL;

    echo "STAGE 4: BATTLE CHINA VS ENGLAND" . PHP_EOL;

    $battle = new Battle();
    $battle->fight($armyChine, $armyEnglish);

    echo "STAGE 4: BATTLE BYZANTINE VS CHINA" . PHP_EOL;
    $battle->fight($armyByzantine, $armyChine);

    echo "STAGE 5: SHOW CHINESE BATTLE HISTORY" . PHP_EOL;
    $historyChinese = $armyChine->getHistoryBattles();
    foreach ($historyChinese as $battle) {
        echo "Battle against: " . $battle['enemyArmyName'] . " - Result: " . $battle['result'] . PHP_EOL;
    }
    echo "STAGE 6: SHOW BYZANTINE BATTLE HISTORY" . PHP_EOL;
    $historyByzantine = $armyByzantine->getHistoryBattles();
    foreach ($historyByzantine as $battle) {
        echo "Battle against: " . $battle['enemyArmyName'] . " - Result: " . $battle['result'] . PHP_EOL;
    }
    echo "STAGE 7: SHOW ENGLISH BATTLE HISTORY" . PHP_EOL;
    $historyEnglish = $armyEnglish->getHistoryBattles();
    foreach ($historyEnglish as $battle) {
        echo "Battle against: " . $battle['enemyArmyName'] . " - Result: " . $battle['result'] . PHP_EOL;
    }

    echo "STAGE 8: SHOW ARMYS AND GOLD AFTER BATTLE" . PHP_EOL;
    echo " ------------------ Chinese ---------------------- " . PHP_EOL;
    echo "Army: " . $armyChine->getArmyName() . " - Gold: " . $armyChine->getGold() . PHP_EOL;
    foreach ($allArmiesChinese as $armyName => $army) {
        foreach ($army->getUnits() as $unit) {
            echo "Army: " . $armyName . " { Unit Type: " . $unit->getType() . " - Strength: " . $unit->getStrength() . " }" . PHP_EOL;
        }
    }

    echo " ------------------ ENGLISH ---------------------- " . PHP_EOL;
    echo "Army: " . $armyEnglish->getArmyName() . " - Gold: " . $armyEnglish->getGold() . PHP_EOL;
    foreach ($allArmiesEnglish as $armyName => $army) {
        foreach ($army->getUnits() as $unit) {
            echo "Army: " . $armyName . " { Unit Type: " . $unit->getType() . " - Strength: " . $unit->getStrength() . " }" . PHP_EOL;
        }
    }

    echo " ------------------ BYZANTINE ---------------------- " . PHP_EOL;
    echo "Army: " . $armyByzantine->getArmyName() . " - Gold: " . $armyByzantine->getGold() . PHP_EOL;
    foreach ($allArmiesByzantine as $armyName => $army) {
        foreach ($army->getUnits() as $unit) {
            echo "Army: " . $armyName . " { Unit Type: " . $unit->getType() . " - Strength: " . $unit->getStrength() . " }" . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
