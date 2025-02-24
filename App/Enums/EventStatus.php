<?php

namespace App\Enums;

enum EventStatus: string {
    case ACTIVE = 'pending';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
}