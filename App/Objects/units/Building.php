<?php

namespace App\Core\Objects;

use App\Core\Objects\Unit;

class Building extends Unit
{
    private $level;

    public function __construct(int $unitId, int $level, float $costMetal, float $costCrystal, float $costDeuterium, float $costEnergy, float $costFactor) {
        parent::__construct($unitId, $costMetal, $costCrystal, $costDeuterium, $costEnergy, $costFactor);
        $this->level = $level;
    }

    public function getCostMetal(): float
    {
        return floor(parent::getCostMetal() * pow(parent::getFactor(), $this->level));
    }

    public function getCostCrystal(): float
    {
        return floor(parent::getCostCrystal() * pow(parent::getFactor(), $this->level));
    }

    public function getCostDeuterium(): float
    {
        return floor(parent::getCostDeuterium() * pow(parent::getFactor(), $this->level));
    }

    public function getCostEnergy(): float
    {
        return floor(parent::getCostEnergy() * pow(parent::getFactor(), $this->level));
    }
    
    public function getEnergyConsumption($metPercent, $crystPercent, $deutPercent) : float {
        switch (parent::getUnitId()) {
            case 1:
                return ceil(10 * $this->level * pow(1.1, $this->level) * ($metPercent / 100));
            case 2:
                return ceil(10 * $this->level * pow(1.1, $this->level) * ($crystPercent / 100));
            case 3:
                return ceil(20 * $this->level * pow(1.1, $this->level) * ($deutPercent / 100));
            default:
                return 0;
        }
    }

}