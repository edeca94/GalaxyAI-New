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

    public function update(): bool
    {
        try 
        {
            $originalData = $this->getPlanetBuildings($this->planetId);

            if (!$originalData) 
            {
                throw new Exception("Errore: nessun edificio trovato per il pianeta ID {$this->planetId}");
            }

            $updates = [];
            $params = [':planetId' => $this->planetId];

            foreach ($originalData as $column => $originalValue) 
            {
                if (property_exists($this, $column) && $this->$column !== $originalValue) 
                {
                    $updates[] = "$column = :$column";
                    $params[":$column"] = $this->$column;
                }
            }

            if (empty($updates)) {
                return false;
            }

            $query = "UPDATE buildings SET " . implode(", ", $updates) . " WHERE planetId = :planetId";

            $stmt = $this->db->executeQuery($query, $params);
            return $stmt->rowCount() > 0;
        } 
        catch (Exception $e) 
        {
            throw new Exception("Errore nell'update: " . $e->getMessage());
        }
    }

    public function createModel(array $buildingsData): self
    {
        Loader::loadBuildingData($this, $buildingsData);
        return $this;
    }
}