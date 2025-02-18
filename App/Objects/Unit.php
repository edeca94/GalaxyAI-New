<?php

namespace App\Core\Objects;

abstract class Unit {

    private $unitId;
    private $costMetal;
    private $costCrystal;
    private $costDeuterium;
    private $costEnergy;
    private $costFactor;

    public function __construct(int $unitId, float $costMetal, float $costCrystal, float $costDeuterium, float $costEnergy, float $costFactor) {
        $this->unitId = $unitId;
        $this->costMetal = $costMetal;
        $this->costCrystal = $costCrystal;
        $this->costDeuterium = $costDeuterium;
        $this->costEnergy = $costEnergy;
        $this->costFactor = $costFactor;
    }

    public function getUnitId() : int {
        return $this->unitId;
    }

    public function getCostMetal() : float {
        return $this->costMetal;
    }

    public function getCostCrystal() : float {
        return $this->costCrystal;
    }

    public function getCostDeuterium() : float {
        return $this->costDeuterium;
    }

    public function getCostEnergy() : float {
        return $this->costEnergy;
    }

    public function getFactor() : float {
        return $this->costFactor;
    }
}