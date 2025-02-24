<?php

namespace App\Enums;

enum EventType: string {
    case BUILDING = 'building';
    case RESEARCH = 'research';
    case SHIP = 'ship';
    case DEFENSE = 'defense';
    case FLIGHT = 'flight';
}