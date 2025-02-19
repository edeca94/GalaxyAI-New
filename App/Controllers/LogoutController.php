<?php

namespace App\Controllers;

use App\Core\Authenticator;
use App\Core\Controller; 

class LogoutController extends Controller
{
    use Authenticator;
    
    public function index()
    {
        $this->logout();
    }
}