<?php


require_once __DIR__ . '/../vendor/autoload.php';

use League\CLImate\CLImate;
use App\Entities\Civilization;
use App\Entities\Units\Unit;
use App\Entities\Units\Pikeman;
use App\Entities\Units\Archer;
use App\Entities\Units\Knight;
use App\Services\UnitTrainingService;
use App\Services\UnitTransformationService;

$climate = new CLImate();

function displayArmyTable(CLImate $climate, array $units, string $label)
{
    $data = [];

    foreach ($units as $index => $unit) {
        $type = (new \ReflectionClass($unit))->getShortName();
        $strength = $unit->getStrength();
        $data[] = [
            'Unit #' => $index + 1,
            'Type' => $type,
            'Strength' => $strength,
        ];
    }

    $climate->bold()->cyan()->out(PHP_EOL . $label);
    $climate->table($data);
}

try {
    $archerInstance = new Archer();

    $climate->bold()->green()->out(PHP_EOL . str_repeat('-', 80));
    $climate->bold()->green()->out("🏹 UNIT TRAINING & TRANSFORMATION DEMO");
    $climate->bold()->green()->out(str_repeat('-', 80) . PHP_EOL);

    // Create civilization and army
    $argentine = new Civilization("Argentine");
    $army = $argentine->createArmy("argentine-first-army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 5],
        ['type' => Unit::ARCHER, 'quantity' => 1],
        ['type' => Unit::KNIGHT, 'quantity' => 1]
    ]);

    // STAGE 1: Initial info
    $climate->blue()->out("STAGE 1: Initial Pikeman Info");
    $pikeman = $army->getUnits()[0];
    $climate->out("Civilization: " . $argentine->getCivilizationName());
    $climate->out("Army: " . $army->getArmyName());
    $climate->out("Pikeman base strength: " . $pikeman->getStrength());
    $climate->yellow()->out("Initial Gold: " . $army->getGold() . PHP_EOL);

    displayArmyTable($climate, $army->getUnits(), "🪖 Army - Initial State");

    // STAGE 2: Train Pikeman
    $climate->blue()->out(PHP_EOL . "STAGE 2: Training Pikeman (x7)");
    $trainer = new UnitTrainingService();

    for ($i = 1; $i <= 7; $i++) {
        $cost = $pikeman->getTrainingCost();
        $goldBefore = $army->getGold();
        $trainer->train($pikeman, $army);
        $goldAfter = $army->getGold();
        $strength = $pikeman->getStrength();

        $climate->green()->out("💪 Training #$i");
        $climate->out(" - Cost: $cost");
        $climate->out(" - Gold: $goldBefore → $goldAfter");
        $climate->out(" - New Strength: $strength");
        $climate->out(str_repeat('-', 40));
    }

    $climate->yellow()->out("Gold after training: " . $army->getGold());

    displayArmyTable($climate, $army->getUnits(), "🪖 Army - After Training");

    // STAGE 3: Transform Pikeman → Archer
    $climate->blue()->out(PHP_EOL . "STAGE 3: Transform Pikeman → Archer   * * WOLOLO * *");

    $transformer = new UnitTransformationService();
    $pikemanBonus = floor(($pikeman->getStrength() - Pikeman::BASE_STRENGTH) / 2);
    $archer = $transformer->transform($pikeman, $army);

    $climate->out(" - Archer base strength: " . Archer::BASE_STRENGTH);
    $climate->out(" - Bonus from Pikeman: $pikemanBonus");
    $climate->out(" - Final Archer strength: " . $archer->getStrength());
    $climate->green()->out("✅ Transformed to Archer");
    $climate->yellow()->out("Gold after transformation: " . $army->getGold());

    // STAGE 4: Transform Archer → Knight
    $climate->blue()->out(PHP_EOL . "STAGE 4: Transform Archer → Knight   * * WOLOLO * *");

    $archerBonus = floor(($archer->getStrength() - Archer::BASE_STRENGTH) / 2);
    $climate->out(" - Knight base strength: " . Knight::BASE_STRENGTH);
    $climate->out(" - Bonus from Archer: $archerBonus");
    $climate->out(" - Final Knight strength: " . ($archer->getStrength() + $archerBonus));

    $knight = $transformer->transform($archer, $army);
    $climate->green()->out("✅ Transformed to Knight");
    $climate->yellow()->out("Gold after transformation: " . $army->getGold());

    // STAGE 5: Attempt invalid transformation
    $climate->blue()->out(PHP_EOL . "STAGE 5: Attempt Invalid Transformation (Knight → ?)");

    $armyUnits = $army->getUnits();
    displayArmyTable($climate, $armyUnits, "🪖 Army - After All Transformations");

    try {
        $transformer->transform($knight, $army);
    } catch (Exception $e) {
        $climate->red()->out("❌ Error: " . $e->getMessage());
    }
} catch (Exception $e) {
    $climate->br();
    $climate->bold()->red()->out("⚠️  Fatal Error: " . $e->getMessage() . PHP_EOL);
}
