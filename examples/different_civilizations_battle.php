<?php

require_once __DIR__ . '/../vendor/autoload.php';

use League\CLImate\CLImate;
use App\Entities\Civilization;
use App\Entities\Units\Unit;
use App\Services\BattleService;

$climate = new CLImate();

function printArmyDetails(CLImate $climate, Civilization $civ, string $color): void
{
    $armies = $civ->getAllArmies();
    foreach ($armies as $armyName => $army) {
        $climate->{$color}()->br()->bold("==> Army: $armyName");
        $climate->yellow("Gold: " . $army->getGold());
        $climate->{$color}("Total Units: " . count($army->getUnits()));
        foreach ($army->getUnits() as $unit) {
            $climate->{$color}("  - {$unit->getType()} (Strength: {$unit->getStrength()})");
        }
    }
}

function printBattleHistory(CLImate $climate, $army, string $color, string $armyName): void
{
    $history = $army->getHistoryBattles();
    if (empty($history)) {
        $climate->{$color}("No battles recorded for $armyName.");
        return;
    }

    $climate->br()->{$color}()->bold("==> $armyName Battle History");
    $climate->table(array_map(function ($b) {
        return [
            'Enemy Army' => $b['enemyArmyName'],
            'Result'     => strtoupper($b['result']),
        ];
    }, $history));
}

$climate->border();
$climate->bold()->out('🛡️  BATTLE BETWEEN ARMIES OF DIFFERENT CIVILIZATIONS');
$climate->border();

try {
    // STAGE 1: CREATE CIVILIZATIONS
    $climate->br()->bold()->out('🏰 STAGE 1: CREATE CIVILIZATIONS');
    $civilizationChine = new Civilization("Chinese");
    $civilizationEnglish = new Civilization("English");
    $civilizationByzantine = new Civilization("Byzantine");

    $climate->red("Created: " . $civilizationChine->getCivilizationName());
    $climate->green("Created: " . $civilizationEnglish->getCivilizationName());
    $climate->blue("Created: " . $civilizationByzantine->getCivilizationName());

    // STAGE 2: CREATE ARMIES
    $climate->br()->bold()->out('⚔️  STAGE 2: CREATE ARMIES');
    $armyChine = $civilizationChine->createArmy("Chinese First Army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 2],
        ['type' => Unit::ARCHER, 'quantity' => 25],
        ['type' => Unit::KNIGHT, 'quantity' => 2]
    ]);
    $armyEnglish = $civilizationEnglish->createArmy("English First Army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 10],
        ['type' => Unit::ARCHER, 'quantity' => 10],
        ['type' => Unit::KNIGHT, 'quantity' => 10]
    ]);
    $armyByzantine = $civilizationByzantine->createArmy("Byzantine First Army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 5],
        ['type' => Unit::ARCHER, 'quantity' => 8],
        ['type' => Unit::KNIGHT, 'quantity' => 15]
    ]);

    $climate->red("Army created: " . $armyChine->getArmyName());
    $climate->green("Army created: " . $armyEnglish->getArmyName());
    $climate->blue("Army created: " . $armyByzantine->getArmyName());

    // STAGE 3: DISPLAY UNITS
    $climate->br()->bold()->out('🧍‍♂️ STAGE 3: DISPLAY UNITS IN ARMIES');
    printArmyDetails($climate, $civilizationChine, 'red');
    printArmyDetails($climate, $civilizationEnglish, 'green');
    printArmyDetails($climate, $civilizationByzantine, 'blue');

    // STAGE 4: TOTAL STRENGTH
    $climate->br()->bold()->out('💪 STAGE 4: SHOW ARMY STRENGTH');
    $climate->red("Chinese Army Strength: " . $armyChine->getTotalStrength());
    $climate->green("English Army Strength: " . $armyEnglish->getTotalStrength());
    $climate->blue("Byzantine Army Strength: " . $armyByzantine->getTotalStrength());

    // STAGE 5: BATTLES
    $climate->br()->bold()->out('⚔️ STAGE 5: BATTLES');
    $battle = new BattleService();

    $climate->red()->bold()->out("🔴 Battle: Chinese vs English");
    $battle->fight($armyChine, $armyEnglish);

    $climate->blue()->bold()->out("🔵 Battle: Byzantine vs Chinese");
    $battle->fight($armyByzantine, $armyChine);

    // STAGE 6: BATTLE HISTORIES
    $climate->br()->bold()->out('📜 STAGE 6: BATTLE HISTORIES');
    printBattleHistory($climate, $armyChine, 'red', 'Chinese');
    printBattleHistory($climate, $armyEnglish, 'green', 'English');
    printBattleHistory($climate, $armyByzantine, 'blue', 'Byzantine');

    // STAGE 7: FINAL STATUS
    $climate->br()->bold()->out('💰 STAGE 7: GOLD & ARMY STATUS AFTER BATTLES');
    printArmyDetails($climate, $civilizationChine, 'red');
    printArmyDetails($climate, $civilizationEnglish, 'green');
    printArmyDetails($climate, $civilizationByzantine, 'blue');
} catch (Exception $e) {
    $climate->error("❌ Error: " . $e->getMessage());
}
