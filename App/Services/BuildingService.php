<?php

namespace App\Services;

use App\Core\Controller;
use App\Core\Authenticator;
use App\Core\PDOFactory;
use App\Core\Database;
use App\Core\Objects\Units;
use App\Core\Objects\Building;

use App\Interfaces\ModelInterface;

use App\Models\BuildingModel;
use App\Models\ShipModel;
use App\Models\DefenseModel;
use App\Models\TechModel;
use App\Models\PlanetModel;
use App\Models\BuildingQueueModel;

class BuildingService extends Controller
{
    use Authenticator;

    protected $userId;
    protected $currentPlanetId;

    public BuildingModel $buildingModel;
    public TechModel $techModel;
    public ShipModel $shipModel;
    public DefenseModel $defenseModel;
    public PlanetModel $planetModel;
    public BuildingQueueModel $buildingQueueModel;

    private $db;

    public function __construct() 
    {
        parent::__construct();
        
        $this->init();
        $this->inside();

        $factory = new PDOFactory();
        $pdo = $factory->createPDO();

        $this->db = new Database($pdo);

        Units::init($this->translator);
    }

    private function init()
    {
        $this->userId = $_SESSION[KWRD_USERID];
        $this->currentPlanetId = $_SESSION[KWRD_CURPLANET];

        $planetModel = new PlanetModel();
        $planetData = $planetModel->getPlanetById($this->currentPlanetId);
        $this->planetModel = $planetModel->createModel($planetData);

        $buildingModel = new BuildingModel();
        $buildingData = $buildingModel->getPlanetBuildings($this->currentPlanetId);
        $this->buildingModel = $buildingModel->createModel($buildingData);

        $shipModel = new ShipModel();
        $shipData = $shipModel->getPlanetShips($this->currentPlanetId);
        $this->shipModel = $shipModel->createModel($shipData);

        $defenseModel = new DefenseModel();
        $defenseData = $defenseModel->getPlanetDefenses($this->currentPlanetId);
        $this->defenseModel = $defenseModel->createModel($defenseData);

        $techModel = new TechModel();
        $techData = $techModel->getUserTechs($this->userId);
        $this->techModel = $techModel->createModel($techData);

        $this->buildingQueueModel = new BuildingQueueModel();
        $this->buildingQueueModel->setPlanetId($this->currentPlanetId);
    }

    public function loadUnitData(array $units): array
    {
        $resources = [];

        foreach ($units as $unit) {
            $functionName = KWRD_GET . ucfirst($unit);
            $id = Units::getUnitId($unit);
            $model = $this->getModel($id);
            $level = $model->$functionName();

            $building = new Building(
                $id,
                $level,
                Units::getPriceList($id)['metal'],
                Units::getPriceList($id)['crystal'],
                Units::getPriceList($id)['deuterium'],
                Units::getPriceList($id)['energy'],
                Units::getPriceList($id)['factor']
            );
            
            $rawBuildingTime = Units::getBuildingTime(
                $building,
                $this->buildingModel->getRobotFactory(),
                $this->buildingModel->getHangar(),
                $this->buildingModel->getNaniteFactory(),
                $this->buildingModel->getResearchLab()
            );

            $buildingTime = $this->formatMilliseconds($rawBuildingTime);

            $requiredResources = [
                'metal' => $building->getCostMetal(),
                'crystal' => $building->getCostCrystal(),
                'deuterium' => $building->getCostDeuterium(),
                'energy' => $building->getCostEnergy()
            ];

            $resources[$id] = [
                'object' => $building,
                'id' => $id,
                'name' => Units::getName($id),
                'description' => Units::getDescription($id),
                'level' => $level,
                'cost_metal' => $this->prettyNumber($building->getCostMetal()),
                'cost_crystal' => $this->prettyNumber($building->getCostCrystal()),
                'cost_deuterium' => $this->prettyNumber($building->getCostDeuterium()),
                'cost_energy' => $this->prettyNumber($building->getCostEnergy()),
                'raw_costs' => [
                    'metal' => $building->getCostMetal(),
                    'crystal' => $building->getCostCrystal(),
                    'deuterium' => $building->getCostDeuterium(),
                    'energy' => $building->getCostEnergy()
                ],
                'building_time' => $buildingTime,
                'raw_building_time' => $rawBuildingTime * 3600,
                'buildable' => $this->areRequirementsMet($id, $model, $unit) && $this->isBuildable($requiredResources)
            ];
        }

        return $resources;
    }

    public function getModel(int $unitId): ModelInterface
    {
        switch (true) {
            case ($unitId > 0 && $unitId < 101):
                return $this->buildingModel;
            case ($unitId > 100 && $unitId < 201):
                return $this->techModel;
            case ($unitId > 200 && $unitId < 301):
                return $this->shipModel;
            case ($unitId > 300 && $unitId < 401):
                return $this->defenseModel;
        }
    }

    public function areRequirementsMet(int $objectId, ModelInterface $model, string $objectName): bool
    {
        $requirements = Units::getRequirements($objectId);
        
        if (is_array($requirements))
        {
            foreach ($requirements as $requiredId => $requiredLevel) {
                $requiredMethodName = KWRD_GET . ucfirst($objectName);
                $level = $model->$requiredMethodName();

                if ($level < $requiredLevel) {
                    return false;
                }
            }
        }

        return true;
    }

    public function isBuildable(array $costs): bool
    {
        $availableResources = [
            'metal' => $this->planetModel->getPlanetMetal(),
            'crystal' => $this->planetModel->getPlanetCrystal(),
            'deuterium' => $this->planetModel->getPlanetDeuterium(),
            'energy' => ($this->planetModel->getPlanetEnergyMax() - $this->planetModel->getPlanetEnergyUsed())
        ];

        foreach ($costs as $resourceType => $cost) {
            if ($availableResources[$resourceType] < $cost) {
                return false;
            }
        }

        return true;
    }

    public function isShipyardAvailable(): bool
    {
        $buildingData = $this->buildingModel->getPlanetBuildings($_SESSION[KWRD_CURPLANET]);
        return $buildingData['hangar'] != 0;
    }

    public function isResearchLabAvailable(): bool
    {
        $buildingData = $this->buildingModel->getPlanetBuildings($_SESSION[KWRD_CURPLANET]);
        return $buildingData['researchLab'] != 0;
    }

    public function saveBuildingEvent($buildingId, $buildingTime, $buildingLevel)
    {
        $queueCount = $this->buildingQueueModel->getBuildingQueueCount();

        if ($queueCount >= 10)
        {
            return [
                'error' => 'Coda costruzioni piena'
            ];
        }

        $position = $queueCount + 1;

        if ($queueCount == 0)
        {
            $startTime = time();
            $endTime = $startTime + $buildingTime;
        }
        else
        {
            $lastEvent = $this->buildingQueueModel->getBuildingQueueLastEvent();
            $lastBuildingLevel = $this->buildingQueueModel->getBuildingMaxLevelInQueue($buildingId);

            $buildingLevel = $lastBuildingLevel + 1;
            $startTime = strtotime($lastEvent['endTime']);
            $endTime = $startTime + $buildingTime;
        }

        $data = [
            'userId' => $this->userId,
            'queuePosition' => $position,
            'buildingId' => $buildingId,
            'buildingLevel' => $buildingLevel,
            'startTime' => (int) $startTime,
            'endTime' => (int) $endTime
        ];

        $this->buildingQueueModel->insertInQueue($data);

        return $queueCount == 0 ? ['startTime' => $startTime, 'endTime' => $endTime, 'buildingId' => $buildingId] : null;
    }

    public function removeBuildingFromQueue($buildingId, $position, $level)
    {
        $this->buildingQueueModel->removeFromQueue($buildingId, $position, $level);
        $this->buildingQueueModel->reorderQueue();

        return true;
    }    

    public function getBuildingQueue()
    {
        return $this->buildingQueueModel->getActiveQueue();
    }    
}