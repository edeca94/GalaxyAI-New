<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Objects\Units;

use App\Services\BuildingService;

class BuildingsController extends Controller
{
    private $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new BuildingService();
    }

    public function index()
    {
        $building = $this->service->buildingModel;
        $units = Units::getResources();
        $buildings = $this->service->loadUnitData($units);

        $this->view([
            'building' => $building,
            'buildings' => $buildings
        ]);
    }
}