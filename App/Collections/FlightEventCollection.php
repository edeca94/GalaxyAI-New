<?php

namespace App\Collections;

use ArrayObject;

use App\Models\FlightEventModel;

class FlightEventCollection extends ArrayObject
{
    public function add(FlightEventModel $flightEvent): void
    {
        $this->append($flightEvent);
    }
}
