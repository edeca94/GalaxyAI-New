<?php

namespace App\Models;

use Exception;

use App\Core\Loader;
use App\Core\Model;
use App\Services\LoaderService;

class PlanetModel extends Model 
{
    protected $planetId;
    protected $planetUserId;
    protected $planetName;
    protected $planetType;
    protected $planetImage;
    protected $planetGalaxy;
    protected $planetSystem;
    protected $planetPosition; 
    protected $planetLastUpdate; 
    protected $planetDestroyed; 
    protected $planetFields; 
    protected $planetTotalFields; 
    protected $planetDiameter; 
    protected $planetMinTemp; 
    protected $planetMaxTemp;
    protected $planetMetal; 
    protected $planetMetalPerHour; 
    protected $planetCrystal; 
    protected $planetCrystalPerHour; 
    protected $planetDeuterium; 
    protected $planetDeuteriumPerHour; 
    protected $planetEnergyUsed; 
    protected $planetEnergyMax; 
    protected $planetMetalMinePercent; 
    protected $planetCrystalMinePercent; 
    protected $planetDeuteriumSynthesizerPercent; 
    protected $planetSolarPlantPercent; 
    protected $planetFusionReactorPercent; 
    protected $planetSolarSatellitePercent; 
    protected $planetLastJumpTime; 
    protected $planetDebrisMetal;
    protected $planetDebrisCrystal; 

    private static $dbToModelMapping = [
        'name' => 'planetName',
        'type' => 'planetType',
        'image' => 'planetImage',
        'galaxy' => 'planetGalaxy',
        'system' => 'planetSystem',
        'position' => 'planetPosition',
        'lastUpdate' => 'planetLastUpdate',
        'destroyed' => 'planetDestroyed',
        'fields' => 'planetFields',
        'totalFields' => 'planetTotalFields',
        'diameter' => 'planetDiameter',
        'minTemp' => 'planetMinTemp',
        'maxTemp' => 'planetMaxTemp',
        'metal' => 'planetMetal',
        'metalPerHour' => 'planetMetalPerHour',
        'crystal' => 'planetCrystal',
        'crystalPerHour' => 'planetCrystalPerHour',
        'deuterium' => 'planetDeuterium',
        'deuteriumPerHour' => 'planetDeuteriumPerHour',
        'energyUsed' => 'planetEnergyUsed',
        'energyMax' => 'planetEnergyMax',
        'metalMinePercent' => 'planetMetalMinePercent',
        'crystalMinePercent' => 'planetCrystalMinePercent',
        'deuteriumSynthesizerPercent' => 'planetDeuteriumSynthesizerPercent',
        'solarPlantPercent' => 'planetSolarPlantPercent',
        'fusionReactorPercent' => 'planetFusionReactorPercent',
        'solarSatellitePercent' => 'planetSolarSatellitePercent',
        'lastJumpTime' => 'planetLastJumpTime',
        'debrisMetal' => 'planetDebrisMetal',
        'debrisCrystal' => 'planetDebrisCrystal',
    ];

    public function assignFirstPlanet($userId) : void
    {
        $position = $this->findNextFreePosition();
        $this->db->insert('planets', [
            'userId' => $userId,
            'galaxy' => $position['galaxy'],
            'system' => $position['system'],
            'position' => $position['position'],
            'totalFields' => 390,
            'name' => 'Home planet',
            'type' => 0,
            'image' => 'default_image.jpg',
            'lastUpdate' => date('Y-m-d H:i:s'),
            'fields' => 0,
            'diameter' => 0,
            'minTemp' => 0,
            'maxTemp' => 0,
            'metal' => 0,
            'metalPerHour' => 0,
            'crystal' => 0,
            'crystalPerHour' => 0,
            'deuterium' => 0,
            'deuteriumPerHour' => 0,
            'energyUsed' => 0,
            'energyMax' => 0,
            'metalMinePercent' => 10,
            'crystalMinePercent' => 10,
            'deuteriumSynthesizerPercent' => 10,
            'solarPlantPercent' => 10,
            'fusionReactorPercent' => 10,
            'solarSatellitePercent' => 10
        ]);

        $planetId = $this->db->getLastInsertId();
        $this->setPlanetId($planetId);
        $this->markPlanetAsColonized($userId, $planetId, $position);

        $loaderService = new LoaderService();
        $loaderService->initAll($this->db, $userId, $planetId);
    }
    
    private function findNextFreePosition(): array
    {
        $primaryPositions = [4, 6, 8, 10, 12];
        $secondaryPositions = [5, 7, 9, 11];
        $allPositions = array_merge($primaryPositions, $secondaryPositions);
    
        for ($galaxy = 1; $galaxy <= 9; $galaxy++) {
            for ($system = 1; $system <= 499; $system++) {
                foreach ($allPositions as $position) {
                    $query = "SELECT COUNT(*) as count FROM colonized WHERE galaxy = :galaxy AND system = :system AND position = :position";
                    $params = [
                        'galaxy' => $galaxy,
                        'system' => $system,
                        'position' => $position,
                    ];
                    $result = $this->db->fetchSingle($query, $params);
    
                    if ($result['count'] == 0) {
                        return ['galaxy' => $galaxy, 'system' => $system, 'position' => $position];
                    }
                }
            }
        }
    
        $this->throwCustomErrorAjax($this->translator->translate('max_players'));
    }

    public function markPlanetAsColonized($userId, $planetId, $coordinates): void
    {
        $galaxy = $coordinates['galaxy'];
        $system = $coordinates['system'];
        $position = $coordinates['position'];

        $this->db->insert('colonized', [
            'userId' => $userId,
            'planetId' => $planetId,
            'galaxy' => $galaxy,
            'system' => $system,
            'position' => $position,
        ]);
    }

    public function getPlanetById(int $planetId): ?array
    {
        try 
        {
            $query = "SELECT * FROM planets WHERE id = :planetId";
            $planetData = $this->db->fetchSingle($query, [':planetId' => $planetId]);

            if ($planetData) 
            {
                return $planetData;
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

    public function createModel(array $planetData): self
    {
        Loader::loadPlanetData($this, $planetData);
        return $this;
    }

    public function update(): bool
    {
        try 
        {
            $originalData = $this->getPlanetById($this->planetId);

            if (!$originalData) 
            {
                throw new Exception("Errore: nessun oggetto trovato per il pianeta ID {$this->planetId}");
            }

            $updates = [];
            $params = [':id' => $this->planetId];

            foreach ($originalData as $column => $originalValue) 
            {
                if (isset(self::$dbToModelMapping[$column])) {
                    $property = self::$dbToModelMapping[$column];
            
                    if (property_exists($this, $property) && (string) $this->$property !== (string) $originalValue) 
                    {
                        $updates[] = "$column = :$column";
                        $params[":$column"] = $this->$property;
                    }
                }
            }

            if (empty($updates)) 
            {
                return false;
            }

            $query = "UPDATE planets SET " . implode(", ", $updates) . " WHERE id = :id";

            $stmt = $this->db->executeQuery($query, $params);
            return $stmt->rowCount() > 0;
        } 
        catch (Exception $e) 
        {
            throw new Exception("Errore nell'update: " . $e->getMessage());
        }
    }
}