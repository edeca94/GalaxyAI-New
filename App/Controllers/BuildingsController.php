<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Objects\Units;

use App\Services\BuildingService;

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
        header('Content-Type: application/json');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if (!isset($_POST['id'])) {
            echo json_encode(['error' => 'ID edificio mancante']);
            exit;
        }

        $buildingId = intval($_POST['id']);

        if (!isset($this->buildings[$buildingId])) {
            echo json_encode(['error' => 'Edificio non trovato']);
            exit;
        }

        $building = $this->buildings[$buildingId];

        if (!isset($building['building_time'])) {
            echo json_encode(['error' => 'Tempo di costruzione non trovato']);
            exit;
        }

        $buildingTime = intval($building['building_time']);
        $newLevel = intval($building['level']) + 1;

        $startTime = time();
        $endTime = $startTime + $buildingTime;

        $this->service->saveBuildingEvent($buildingId, $startTime, $endTime, $newLevel);

        echo json_encode([
            'success' => true,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'level' => $newLevel,
            'buildTime' => $buildingTime
        ]);
        exit;
    }
}
