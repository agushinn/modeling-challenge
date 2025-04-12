<?php

namespace App\Interfaces;

interface CivilizationInterface
{
    public function getCivilizationName();
    public function createArmy(string $armyName, array $soldiers);
    public function getAllArmies();
    public function getArmy(string $armyName);
}
