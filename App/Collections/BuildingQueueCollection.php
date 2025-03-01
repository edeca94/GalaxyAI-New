<?php

namespace App\Collections;

use ArrayObject;

use App\Models\BuildingQueueModel;

class BuildingQueueCollection extends ArrayObject
{
    public function add(BuildingQueueModel $buildingQueueModel): void
    {
        $this->append($buildingQueueModel);
    }
}