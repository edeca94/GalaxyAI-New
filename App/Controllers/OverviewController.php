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
        $userModel = $this->baseData['user'];
        $userData = $userModel->getUserById($_SESSION[KWRD_USERID]);
        $this->userModel = $userModel->createModel($userData);
    }

    public function index(): void
    {
        $this->init();

        $this->view([]);
    }
}