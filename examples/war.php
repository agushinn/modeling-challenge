<?php

require_once __DIR__ . '/../vendor/autoload.php';

use League\CLImate\CLImate;
use App\Entities\Civilization;
use App\Entities\Units\Unit;
use App\Services\BattleService;
use App\Services\UnitTrainingService;
use App\Services\UnitTransformationService;

$climate = new CLImate();
$trainService = new UnitTrainingService();
$transformService = new UnitTransformationService();

function showArmyDetails(CLImate $climate, Civilization $civ, string $color, string $context = 'Initial Army Details')
{
    $climate->br()->{$color}()->bold("==> {$context}: " . $civ->getCivilizationName());

    foreach ($civ->getAllArmies() as $armyName => $army) {
        $climate->{$color}(" Army: $armyName");
        $climate->yellow(" Gold: {$army->getGold()}");
        $climate->{$color}(" Total Units: " . count($army->getUnits()));
        $climate->{$color}(" Total Strength: " . $army->getTotalStrength());

        foreach ($army->getUnits() as $unit) {
            $climate->{$color}("   - {$unit->getType()} (Strength: {$unit->getStrength()})");
        }
    }
}

function showBattleLog(CLImate $climate, $army, string $color, string $title)
{
    $climate->br()->{$color}()->bold("==> $title");
    $log = $army->getHistoryBattles();
    if (empty($log)) {
        $climate->yellow(" No battles yet.");
        return;
    }
    $climate->table(array_map(fn($entry) => [
        'Opponent' => $entry['enemyArmyName'],
        'Result' => strtoupper($entry['result']),
    ], $log));
}

function showUnitsTable(CLImate $climate, $army, string $color)
{
    $climate->{$color}()->table(array_map(fn($unit) => [
        'Type' => $unit->getType(),
        'Strength' => $unit->getStrength()
    ], $army->getUnits()));
}

$climate->border();
$climate->bold()->out("🏹 CIVILIZATION WAR: TRAINING AND TRANSFORMATION SCENARIO");
$climate->border();

try {
    // STEP 1: CREATE CIVILIZATIONS AND ARMIES
    $climate->br()->bold()->out('🌍 STEP 1: Create Civilizations and Armies');

    $civA = new Civilization("Vikings");
    $civB = new Civilization("Samurais");

    $armyA = $civA->createArmy("Viking Army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 2],
        ['type' => Unit::ARCHER, 'quantity' => 2],
        ['type' => Unit::KNIGHT, 'quantity' => 2],
    ]);

    $armyB = $civB->createArmy("Samurai Army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 2],
        ['type' => Unit::ARCHER, 'quantity' => 2],
        ['type' => Unit::KNIGHT, 'quantity' => 2],
    ]);

    showArmyDetails($climate, $civA, 'cyan');
    showArmyDetails($climate, $civB, 'green');

    // STEP 2: FIRST BATTLE (DRAW)
    $climate->br()->bold()->out('⚔️ STEP 2: First Battle (Expecting a Draw)');
    $battle = new BattleService();
    $battle->fight($armyA, $armyB);

    $climate->br()->yellow()->bold("📊 Post-Battle Details (After Draw)");
    showArmyDetails($climate, $civA, 'cyan', 'Vikings');
    showArmyDetails($climate, $civB, 'green', 'Samurais');

    // STEP 3: TRAINING AND TRANSFORMATION
    $climate->br()->bold()->out('🧠 STEP 3: Training and Transformation');

    $unitToTrainA = $armyA->getUnits()[0];
    $unitToTransformA = $armyA->getUnits()[1];
    $unitToTrainB = $armyB->getUnits()[0];
    $unitToTransformB = $armyB->getUnits()[1];

    $trainService->train($unitToTrainA, $armyA);
    $trainService->train($unitToTrainB, $armyB);
    $transformService->transform($unitToTransformA, $armyA);
    $transformService->transform($unitToTransformB, $armyB);


    $climate->cyan("🛠️ Vikings - Trained unit: {$unitToTrainA->getType()} → Strength: {$unitToTrainA->getStrength()}");
    $climate->cyan("🌀 Vikings - Transformed unit: Now a {$unitToTransformA->getType()}");

    $climate->green("🛠️ Samurais - Trained unit: {$unitToTrainB->getType()} → Strength: {$unitToTrainB->getStrength()}");
    $climate->green("🌀 Samurais - Transformed unit: Now a {$unitToTransformB->getType()}");

    // STEP 4: POST-TRAINING STATUS
    $climate->br()->bold()->out('📋 STEP 4: Status After Training and Transformation');
    showArmyDetails($climate, $civA, 'cyan', 'Vikings');
    showArmyDetails($climate, $civB, 'green', 'Samurais');

    // STEP 5: SECOND BATTLE
    $climate->br()->bold()->out('⚔️ STEP 5: Second Battle (Expecting a Winner)');
    $battle->fight($armyA, $armyB);

    // STEP 6: FINAL RESULTS
    $climate->br()->bold()->out('🏁 STEP 6: Final Results');
    showBattleLog($climate, $armyA, 'cyan', 'Vikings Battle History');
    showBattleLog($climate, $armyB, 'green', 'Samurais Battle History');

    $climate->br()->cyan()->bold("🏆 Final Army Status - Vikings");
    showArmyDetails($climate, $civA, 'cyan');

    $climate->green()->bold("💀 Final Army Status - Samurais");
    showArmyDetails($climate, $civB, 'green');
} catch (Exception $e) {
    $climate->error("❌ Error: " . $e->getMessage());
}
