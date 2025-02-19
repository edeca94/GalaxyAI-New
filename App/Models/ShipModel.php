<?php

namespace App\Models;

use App\Core\Loader;
use App\Core\Model;

use App\Interfaces\ModelInterface;

use Exception;

class ShipModel extends Model implements ModelInterface
{
    protected int $id;
    protected int $planetId;
    protected int $smallCargo;
    protected int $largeCargo;
    protected int $lightFighter;
    protected int $heavyFighter;
    protected int $cruiser;
    protected int $battleship;
    protected int $colonyShip;
    protected int $recycler;
    protected int $espionageProbe;
    protected int $bomber;
    protected int $solarSatellite;
    protected int $destroyer;
    protected int $deathStar;
    protected int $battlecruiser;

    public function getPlanetShips(int $planetId): ?array
    {
        try 
        {
            $query = "SELECT * FROM ships WHERE planetId = :planetId";
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

    public function createModel(array $shipsData): self
    {
        Loader::loadShipData($this, $shipsData);
        return $this;
    }
}