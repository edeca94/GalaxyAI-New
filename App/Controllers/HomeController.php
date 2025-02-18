<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'GalaxyAI - Overview'
        ];
        
        $this->set('title', $data['title']);
        $this->view($data);
    }
}
