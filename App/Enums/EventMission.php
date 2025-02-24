<?php

namespace App\Enums;

enum EventMission: string {
    case ATTACK = 'attack';
    case TRANSPORT = 'transport';
    case DEPLOY = 'deploy';
    case EXPEDITION = 'expedition';
    case HOLD = 'hold';
    case SPY = 'spy';
    case COLONIZE = 'colonize';
    case RECYCLE = 'recycle';
    case DESTROY = 'destroy';

    public function getImagePath(): string
    {
        return match ($this) {
            self::ATTACK => BASE_URL . '/public/resources/missions/attack.gif',
            self::TRANSPORT => BASE_URL . '/public/resources/missions/transport.gif',
            self::DEPLOY => BASE_URL . '/public/resources/missions/deploy.gif',
            self::EXPEDITION => BASE_URL . '/public/resources/missions/expedition.gif',
            self::HOLD => BASE_URL . '/public/resources/missions/hold.gif',
            self::SPY => BASE_URL . '/public/resources/missions/spy.gif',
            self::COLONIZE => BASE_URL . '/public/resources/missions/colonize.gif',
            self::RECYCLE => BASE_URL . '/public/resources/missions/recycle.gif',
            self::DESTROY => BASE_URL . '/public/resources/missions/destroy.gif',
        };
    }
}