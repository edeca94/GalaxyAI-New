<?php

namespace App\Models;

use App\Core\Loader;
use App\Core\Model;

use Exception;

class TechModel extends Model
{
    protected int $id;
    protected int $userId;
    protected int $currentReasearchId;
    protected int $espionageTech;
    protected int $computerTech;
    protected int $weaponTech;
    protected int $armourTech;
    protected int $shieldingTech;
    protected int $energyTech;
    protected int $hyperspaceTech;
    protected int $combustionDriveTech;
    protected int $impulseDriveTech;
    protected int $hyperspaceDriveTech;
    protected int $laserTech;
    protected int $ionTech;
    protected int $plasmaTech;
    protected int $intergalacticResearchTech;
    protected int $gravitonTech;

    public function getUserTechs(int $planetId): ?array
    {
        try 
        {
            $query = "SELECT * FROM researches WHERE userId = :userId";
            $techData = $this->db->fetchSingle($query, [':userId' => $planetId]);

            if ($techData) 
            {
                return $techData;
            } 
            else 
            {
                //throw new Exception("Alliance not found.");
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception($e->getMessage());
        }

        return null;
    }

    public function createModel(array $techData): self
    {
        Loader::loadTechData($this, $techData);
        return $this;
    }
}