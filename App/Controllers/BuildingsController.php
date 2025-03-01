<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Objects\Units;

use App\Models\BuildingQueueModel;

use App\Collections\BuildingQueueCollection;

use App\Helpers\RequestHelper;

use App\Services\BuildingService;

use Exception;

class BuildingsController extends Controller
{
    private $service;
    private $buildings;
    private $buildingQueue;

    public function __construct()
    {
        parent::__construct();
        $this->service = new BuildingService();
        $this->buildingQueue = $this->service->getBuildingQueue();

        $units = Units::getResources();
        $this->buildings = $this->service->loadUnitData($units);
    }

    public function index()
    {
        $building = $this->service->buildingModel;

        $buildingQueueCollection = new BuildingQueueCollection();
        foreach ($this->buildingQueue as $queueItem) 
        {
            $buildingQueueModel = new BuildingQueueModel();
            $buildingQueueModel = $buildingQueueModel->createModel($queueItem);
            $buildingQueueCollection->add($buildingQueueModel);
        }
        //foreach in buildings getBuildingMaxLevelInQueue and insert nextLevel with sum of current + queue a
        //var_dump($buildingQueueCollection); exit;

        $this->view([
            'building' => $building,
            'buildings' => $this->buildings,
            'queue' => $buildingQueueCollection
        ]);
    }

    public function addToQueue()
    {
        RequestHelper::validatePostParams(['id']);
        $buildingId = intval($_POST['id']);

        $building = $this->buildings[$buildingId];
        $newLevel = intval($building['nextLevel']);

        try 
        {
            $result = $this->service->saveBuildingEvent($buildingId, $building['raw_building_time'], $newLevel);

            $this->buildingQueue = $this->service->getBuildingQueue();

            if ($result)
            {
                $response = [
                    'success' => true,
                    'queue' => $this->buildingQueue
                ];

                $this->jsonResponse($response);
            }
            else
            {
                $this->jsonResponse(['success' => false]);
            }
        }
        catch (Exception $e)
        {
            $this->jsonResponse(['error' => $e->getMessage()]);
        }
    }

    public function removeFromQueue()
    {
        RequestHelper::validatePostParams(['id', 'position', 'level']);
        $buildingId = intval($_POST['id']);
        $position = intval($_POST['position']);
        $level = intval($_POST['level']);

        try 
        {
            $result = $this->service->removeBuildingFromQueue($buildingId, $position, $level);

            $this->buildingQueue = $this->service->getBuildingQueue();

            if ($result)
            {
                $response = [
                    'success' => true,
                    'queue' => $this->buildingQueue
                ];

                $this->jsonResponse($response);
            }
            else
            {
                $this->jsonResponse(['success' => false]);
            }
        }
        catch (Exception $e)
        {
            $this->jsonResponse(['error' => $e->getMessage()]);
        }
    }
}