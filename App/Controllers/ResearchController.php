<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Objects\Units;

use App\Services\BuildingService;

class ResearchController extends Controller
{
    private $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new BuildingService();
    }

    public function index()
    {
        if (!$this->service->isResearchLabAvailable())
        {
            $this->view([
                'message' => $this->translator->translate('techlab_not_available')
            ]);
            return;
        }

        $building = $this->service->buildingModel;
        $units = Units::getTechnologies();
        $buildings = $this->service->loadUnitData($units);

        $this->view([
            'building' => $building,
            'buildings' => $buildings
        ]);
    }
}