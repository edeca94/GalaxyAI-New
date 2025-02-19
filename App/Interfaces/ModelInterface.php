<?php

namespace App\Interfaces;

use App\Core\Model;

interface ModelInterface {
    
    public function createModel(array $data): Model;
    
}