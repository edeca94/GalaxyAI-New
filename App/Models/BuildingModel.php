<?php

namespace App\Models;

use App\Core\Loader;
use App\Core\Model;

use App\Interfaces\ModelInterface;

use Exception;

class BuildingModel extends Model implements ModelInterface
{
    protected int $id;
    protected int $planetId;
    protected int $metalMine;
    protected int $crystalMine;
    protected int $deuteriumSynthesizer;
    protected int $solarPlant;
    protected int $fusionReactor;
    protected int $robotFactory;
    protected int $naniteFactory;
    protected int $hangar;
    protected int $metalStore;
    protected int $crystalStore;
    protected int $deuteriumTank;
    protected int $researchLab;
    protected int $university;
    protected int $terraformer;
    protected int $allianceDepot;
    protected int $missileBase;
    protected int $lunarOutpost;
    protected int $phalanx;
    protected int $hyperspacePortal;

    public function getPlanetBuildings(int $planetId): ?array
    {
        try 
        {
            $query = "SELECT * FROM buildings WHERE planetId = :planetId";
            $buildingsData = $this->db->fetchSingle($query, [':planetId' => $planetId]);

            if ($buildingsData) 
            {
                return $buildingsData;
            } 
        } 
        catch (Exception $e) 
        {
            throw new Exception($e->getMessage());
        }

        return null;
    }

    public function createModel(array $buildingsData): self
    {
        Loader::loadBuildingData($this, $buildingsData);
        return $this;
    }
}