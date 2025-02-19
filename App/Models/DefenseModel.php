<?php

namespace App\Models;

use App\Core\Loader;
use App\Core\Model;
use App\Interfaces\ModelInterface;
use Exception;

class DefenseModel extends Model implements ModelInterface
{
    protected int $id;
    protected int $planetId;
    protected int $rocketLauncher;
    protected int $lightLaser;
    protected int $heavyLaser;
    protected int $gaussCannon;
    protected int $ionCannon;
    protected int $plasmaTurret;
    protected int $smallShieldDome;
    protected int $largeShieldDome;
    protected int $antiBallisticMissile;
    protected int $interplanetaryMissile;

    public function getPlanetDefenses(int $planetId): ?array
    {
        try 
        {
            $query = "SELECT * FROM defenses WHERE planetId = :planetId";
            $shipsData = $this->db->fetchSingle($query, [':planetId' => $planetId]);

            if ($shipsData) 
            {
                return $shipsData;
            } 
        } 
        catch (Exception $e) 
        {
            throw new Exception($e->getMessage());
        }

        return null;
    }

    public function createModel($defenseData): self
    {
        Loader::loadDefenseData($this, $defenseData);
        return $this;
    }
}