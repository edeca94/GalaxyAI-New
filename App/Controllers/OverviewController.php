<?php

namespace App\Controllers;

use App\Core\Controller;

use App\Models\UserModel;

class OverviewController extends Controller
{
    protected UserModel $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->inside();
    }

    private function init()
    {
        $this->userModel = $this->baseData['user'];
    }

    public function index(): void
    {
        $this->init();

        $this->view([]);
    }
}