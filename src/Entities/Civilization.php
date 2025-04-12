<?php

namespace App\Entities;

use App\Entities\Units\Archer;
use App\Entities\Units\Knight;
use App\Entities\Units\Pikeman;
use App\Entities\Units\Unit;
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
            // The concrete class is determined based on the received type.
            for ($i = 0; $i < $soldier['quantity']; $i++) {
                switch ($soldier['type']) {
                    case Unit::PIKEMAN:
                        $unit = new Pikeman();
                        break;
                    case Unit::ARCHER:
                        $unit = new Archer();
                        break;
                    case Unit::KNIGHT:
                        $unit = new Knight();
                        break;
                    default:
                        throw new Exception("Unknown unit type: " . $soldier['type']);
                }
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
