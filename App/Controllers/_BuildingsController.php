<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Objects\Units;

use App\Helpers\RequestHelper;

use App\Services\BuildingService;

use Exception;

class BuildingsController extends Controller
{
    private $service;
    private $buildings;

    public function __construct()
    {
        parent::__construct();
        $this->service = new BuildingService();

        $units = Units::getResources();
        $this->buildings = $this->service->loadUnitData($units);
    }

    public function index()
    {
        $building = $this->service->buildingModel;

        $this->view([
            'building' => $building,
            'buildings' => $this->buildings
        ]);
    }

    public function startConstruction()
    {
        RequestHelper::validatePostParams(['id']);

        $buildingId = intval($_POST['id']);

        if (!isset($this->buildings[$buildingId])) {
            $this->jsonResponse(['error' => 'Edificio non trovato']);
        }

        $building = $this->buildings[$buildingId];
        $newLevel = intval($building['level']) + 1;

        try {
            $result = $this->service->saveBuildingEvent($buildingId, $building['raw_building_time'], $newLevel);

            $response = [
                'success' => true,
                'message' => "Costruzione aggiunta alla coda",
                'queue' => $this->service->getBuildingQueue()
            ];

            if ($result) {
                $response['active'] = true;
                $response['buildingId'] = $result['buildingId'];
                $response['startTime'] = $result['startTime'];
                $response['endTime'] = $result['endTime'];
            }

            $this->jsonResponse($response);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()]);
        }
    }

    public function removeFromQueue()
    {
        RequestHelper::validatePostParams(['id', 'position', 'level']);

        $buildingId = intval($_POST['id']);
        $position = intval($_POST['position']);
        $level = intval($_POST['level']);

        try {
            $result = $this->service->removeBuildingFromQueue($buildingId, $position, $level);

            if ($result) {
                $this->jsonResponse([
                    'success' => true,
                    'message' => "Costruzione rimossa dalla coda",
                    'queue' => $this->service->getBuildingQueue()
                ]);
            } else {
                $this->jsonResponse(['error' => "Errore nella rimozione dell'edificio dalla coda"]);
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()]);
        }
    }

    public function getActiveBuildings()
    {
        $queue = $this->service->getBuildingQueue();

        $this->jsonResponse([
            'success' => true,
            'queue' => $queue ? $queue : []
        ]);
    }
}