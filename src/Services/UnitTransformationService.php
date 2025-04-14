<?php

namespace App\Services;

use App\Entities\Army;
use App\Entities\Units\Unit;
use App\Entities\Units\Pikeman;
use App\Entities\Units\Archer;
use App\Entities\Units\Knight;
use App\Factories\UnitFactory;
use Exception;

class UnitTransformationService
{
    public function transform(Unit $unit, Army $army): Unit
    {
        $newUnit = null;

        switch ($unit->getType()) {
            case Unit::PIKEMAN:
                if ($army->getGold() < Pikeman::TRANSFORMATION_COST) {
                    throw new Exception("* * WOLOLOn't * * Gold insufficient to transform to Archer.");
                }
                $army->setGold($army->getGold() - Pikeman::TRANSFORMATION_COST);
                $extra = $unit->getStrength() - Pikeman::BASE_STRENGTH;
                $bonus = floor($extra / 2);
                $newUnit = UnitFactory::createUnit(Unit::ARCHER);
                $newUnit->setStrength(Archer::BASE_STRENGTH + $bonus);
                break;

            case Unit::ARCHER:
                if ($army->getGold() < Archer::TRANSFORMATION_COST) {
                    throw new Exception("* * WOLOLOn't * * Gold insufficient to transform to Knight.");
                }
                $army->setGold($army->getGold() - Archer::TRANSFORMATION_COST);
                $extra = $unit->getStrength() - Archer::BASE_STRENGTH;
                $bonus = floor($extra / 2);
                $newUnit = UnitFactory::createUnit(Unit::KNIGHT);
                $newUnit->setStrength(Knight::BASE_STRENGTH + $bonus);
                break;

            case Unit::KNIGHT:
                throw new Exception("* * WOLOLOn't * * Knight cannot be transformed.");

            default:
                throw new Exception("* * WOLOLOn't * * Unknown unit type: " . $unit->getType());
        }

        $army->removeUnit($unit);
        $army->addUnit($newUnit);

        return $newUnit;
    }
}
