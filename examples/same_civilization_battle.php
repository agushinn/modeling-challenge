<?php

require_once __DIR__ . '/../vendor/autoload.php';

use League\CLImate\CLImate;
use App\Entities\Civilization;
use App\Entities\Units\Unit;
use App\Services\BattleService;

$climate = new CLImate();

$climate->bold()->green()->out(PHP_EOL . str_repeat('-', 80));
$climate->bold()->green()->out("BATTLE BETWEEN TWO ARMIES OF THE SAME CIVILIZATION");
$climate->bold()->green()->out(str_repeat('-', 80) . PHP_EOL);

try {
    $climate->bold()->blue()->out(PHP_EOL . "⚔️  CHINESE vs CHINESE");

    // STAGE 1
    $climate->bold()->out(PHP_EOL . "🔧 STAGE 1: CREATE CIVILIZATION");
    $civilizationChine = new Civilization("Chinese");
    $climate->red("🏰 New civilization created: " . $civilizationChine->getCivilizationName());

    // STAGE 2
    $climate->bold()->out(PHP_EOL . "🛡️ STAGE 2: CREATE ARMIES");

    $civilizationChine->createArmy("chinese first army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 1],
        ['type' => Unit::ARCHER, 'quantity' => 2],
        ['type' => Unit::KNIGHT, 'quantity' => 1]
    ]);

    $civilizationChine->createArmy("chinese second army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 1],
        ['type' => Unit::ARCHER, 'quantity' => 1],
        ['type' => Unit::KNIGHT, 'quantity' => 4]
    ]);

    $climate->cyan("🪖 Army created: " . $civilizationChine->getAllArmies()['chinese-first-army']->getArmyName());
    $climate->red("🪖 Army created: " . $civilizationChine->getAllArmies()['chinese-second-army']->getArmyName());

    // STAGE 3
    $climate->bold()->out(PHP_EOL . "📊 STAGE 3: SHOW ARMY STRENGTH");

    $allArmiesChinese = $civilizationChine->getAllArmies();

    foreach ($allArmiesChinese as $armyName => $army) {
        $climate->border()->green()->out(" 🪖 ARMY: " . strtoupper($armyName) . " ");
        $color = $armyName === 'chinese-first-army' ? 'cyan' : 'red';
        $climate->$color()->out("💪 Total Strength: " . $army->getTotalStrength());

        foreach ($army->getUnits() as $unit) {
            $climate->$color()->out("   🔹 Unit Type: {$unit->getType()} | Strength: {$unit->getStrength()}");
        }
    }

    // STAGE 4
    $climate->bold()->out(PHP_EOL . "🔥 STAGE 4: BATTLE BEGINS - CHINESE vs CHINESE 🔥");

    $battle = new BattleService();
    $battle->fight(
        $allArmiesChinese['chinese-first-army'],
        $allArmiesChinese['chinese-second-army']
    );

    // STAGE 5
    $climate->bold()->out(PHP_EOL . "📜 STAGE 5: BATTLE HISTORY - CHINESE-FIRST-ARMY");
    $history = $allArmiesChinese['chinese-first-army']->getHistoryBattles();
    foreach ($history as $battle) {
        $climate->cyan("🆚 Against: {$battle['enemyArmyName']} | 🏁 Result: {$battle['result']}");
    }

    // STAGE 6
    $climate->bold()->out(PHP_EOL . "📜 STAGE 6: BATTLE HISTORY - CHINESE-SECOND-ARMY");
    $history = $allArmiesChinese['chinese-second-army']->getHistoryBattles();
    foreach ($history as $battle) {
        $climate->red("🆚 Against: {$battle['enemyArmyName']} | 🏁 Result: {$battle['result']}");
    }

    // STAGE 7
    $climate->bold()->out(PHP_EOL . "💰 STAGE 7: ARMIES' GOLD AFTER BATTLE");
    $climate->yellow("💎 chinese-first-army: " . $allArmiesChinese['chinese-first-army']->getGold() . " gold");
    $climate->yellow("💎 chinese-second-army: " . $allArmiesChinese['chinese-second-army']->getGold() . " gold");

    // STAGE 8
    $climate->bold()->out(PHP_EOL . "🪖 STAGE 8: REMAINING UNITS AFTER BATTLE");

    foreach ($allArmiesChinese as $armyName => $army) {
        $climate->border()->green()->out(" 🪖 ARMY: " . strtoupper($armyName) . " ");
        $color = $armyName === 'chinese-first-army' ? 'cyan' : 'red';
        foreach ($army->getUnits() as $unit) {
            $climate->$color()->out("   🔸 Unit Type: {$unit->getType()} | Strength: {$unit->getStrength()}");
        }
    }
} catch (Exception $e) {
    $climate->error("❌ Error: " . $e->getMessage());
}
