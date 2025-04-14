<?php

namespace App\Entities;

use App\Factories\UnitFactory;
use App\Helpers\Formatter;
use App\Interfaces\CivilizationInterface;

use Exception;

class Civilization implements CivilizationInterface
{
    private $civilizationName;
    private $armies = [];

    public function __construct($civilizationName)
    {
        $this->civilizationName = $civilizationName;
    }

    public function getCivilizationName()
    {
        return $this->civilizationName;
    }

    public function createArmy(string $armyName, array $soldiers)
    {
        $formattedArmyName = Formatter::formatName($armyName);
        if (isset($this->armies[$formattedArmyName])) {
            throw new Exception("Army '$formattedArmyName' already exists in civilization '{$this->civilizationName}'");
        }

        $army = new Army($formattedArmyName);
        foreach ($soldiers as $soldier) {
            for ($i = 0; $i < $soldier['quantity']; $i++) {
                $unit = UnitFactory::createUnit($soldier['type']);
                $army->addUnit($unit);
            }
        }

        $this->armies[$formattedArmyName] = $army;
        return $army;
    }

    public function getArmy(string $armyName)
    {
        $formattedArmyName = Formatter::formatName($armyName);

        if (isset($this->armies[$formattedArmyName])) {
            return $this->armies[$formattedArmyName];
        }
        throw new Exception(" Army '$formattedArmyName' not found in civilization '{$this->civilizationName}'");
    }

    public function getAllArmies()
    {
        return $this->armies;
    }
}
