<?php

namespace App\Factories;

use App\Entities\Units\Pikeman;
use App\Entities\Units\Archer;
use App\Entities\Units\Knight;
use App\Entities\Units\Unit;
use Exception;

class UnitFactory
{
    public static function createUnit(string $unitType): Unit
    {
        switch ($unitType) {
            case Unit::PIKEMAN:
                return new Pikeman();
            case Unit::ARCHER:
                return new Archer();
            case Unit::KNIGHT:
                return new Knight();
            default:
                throw new Exception("Unknown unit type: $unitType");
        }
    }
}
