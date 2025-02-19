<?php

namespace App\Controllers;

use App\Core\Authenticator;
use App\Core\Controller;

use App\Models\UserModel;
use App\Models\PlanetModel;

class HomeController extends Controller 
{
    use Authenticator;

    public function index() 
    {
        if ($this->authenticate())
        {
            header('Location: /overview');
        }

        $this->view([], true);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();

            $userModel->login($email, $password);

            if ($userModel->getUserId())
            {
                $this->setSession($userModel);
                header('Location: /overview');
            }
        }
    }

    public function register() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $planetModel = new PlanetModel();

            $userId = $userModel->registerUser($email, $username, $password);
            if ($userId)
            {
                $planetModel->assignFirstPlanet($userId);
                $userModel->updateMainPlanet($planetModel->getPlanetId());
                $userModel->login($email, $password);
            }
        }
    }
}