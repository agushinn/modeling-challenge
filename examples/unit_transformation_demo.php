<?php

require_once __DIR__ . '/../vendor/autoload.php';



use App\Entities\Civilization;
use App\Entities\Units\Unit;

try {
    echo " ------------------ TRAIN PIKEMAN AND TRANSFORM TO ARCHER ---------------------- " . PHP_EOL;
    $argentineCivilization = new Civilization("Argentine");
    $argentineArmy = $argentineCivilization->createArmy("Argentine First Army", [
        ['type' => Unit::PIKEMAN, 'quantity' => 5],
        ['type' => Unit::ARCHER, 'quantity' => 1],
        ['type' => Unit::KNIGHT, 'quantity' => 1]
    ]);

    echo 'Before train pikeman' . PHP_EOL;
    $argentinePikeman = $argentineArmy->getUnits()[0];
    var_dump($argentinePikeman) . PHP_EOL;;
    var_dump($argentineArmy->getGold()) . PHP_EOL;;

    echo 'After train pikeman' . PHP_EOL;
    $argentinePikeman->train($argentineArmy);
    $argentinePikeman->train($argentineArmy);
    $argentinePikeman->train($argentineArmy);
    $argentinePikeman->train($argentineArmy);
    $argentinePikeman->train($argentineArmy);
    $argentinePikeman->train($argentineArmy);
    $argentinePikeman->train($argentineArmy);
    var_dump($argentinePikeman) . PHP_EOL;
    var_dump($argentineArmy->getGold()) . PHP_EOL;

    echo 'Transform pikeman to archer' . " * * WOLOLO * *"  . PHP_EOL;
    $argentinePikeman = $argentinePikeman->transform($argentineArmy);
    var_dump($argentinePikeman);
    var_dump($argentineArmy->getGold());
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
