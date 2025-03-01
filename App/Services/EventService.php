<?php

namespace App\Services;

use App\Core\PDOFactory;
use App\Core\Database;

use App\Core\Objects\Units;

use App\Models\BuildingModel;

class EventService {
    protected $db;

    public function __construct()
    {
        $factory = new PDOFactory();
        $pdo = $factory->createPDO();

        $this->db = new Database($pdo);
    }

    public function evaluateQueue($userId = null): array
    {
        $data = [];

        if ($userId === null) {
            $queue = $this->db->fetchAll(
                'SELECT * FROM buildingQueue WHERE UNIX_TIMESTAMP(endTime) <= UNIX_TIMESTAMP()'
            );
        }
        else
        {    
            $userId = $_SESSION[KWRD_USERID];
            $queue = $this->db->fetchAll(
                'SELECT * FROM buildingQueue WHERE userId = :userId AND UNIX_TIMESTAMP(endTime) <= UNIX_TIMESTAMP()',
                ['userId' => $userId]
            );
        }

        if (empty($queue))
        {
            return [];
        }
    
        if (!empty($queue)) {
            $data['queue_item_count'] = count($queue);
            $data['queue_items'] = $queue;

            foreach ($queue as $event) {
                $buildingModel = new BuildingModel();
                $buildingData = $buildingModel->getPlanetBuildings($event['planetId']);
                $userId = $event['userId'];
    
                if (!$buildingData) {
                    continue;
                }
    
                $building = $buildingModel->createModel($buildingData);
    
                $buildingProperty = Units::getUnitName($event['buildingId']);
    
                if ($buildingProperty && property_exists($building, $buildingProperty)) {
                    $setLevel = KWRD_SET . ucfirst($buildingProperty);
    
                    $building->$setLevel($event['buildingLevel']);
                    if ($building->update())
                    {
                        $this->db->delete(
                            'buildingQueue',
                            'userId = :userId AND planetId = :planetId AND buildingId = :buildingId',
                            ['userId' => $userId, 'planetId' => $event['planetId'], 'buildingId' => $event['buildingId']]
                        );
                        return $data;
                    }
                    else
                    {
                        return [];
                    }
                }
            }
        }
        
        return $data;
    }
    
}