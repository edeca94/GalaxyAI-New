<?php

namespace App\Services;

use App\Core\Authenticator;

use App\Models\MessageModel;
use App\Models\UserModel;
use App\Models\PlanetModel;
use App\Models\FlightEventModel;

use App\Collections\FlightEventCollection;

class LoaderService
{
    use Authenticator;

    public function loadBaseData()
    {
        if (!$this->authenticate())
        {
            return [];
        }

        $baseData = array();

        $userModel = new UserModel();
        $userData = $userModel->getUserById($_SESSION[KWRD_USERID]);
        $baseData['user'] = $userModel->createModel($userData);

        $planetModel = new PlanetModel();
        $planetData = $planetModel->getPlanetById($userModel->getUserCurrentPlanetId());
        $baseData['planet'] = $planetModel->createModel($planetData);

        $messageModel = new MessageModel();
        $unreadMessages = $messageModel->countUnreadMessages($userModel->getUserId());
        $baseData['unreadMessages'] = $unreadMessages;

        //$baseData['flights'] = $this->loadFlights();

        return $baseData;
    }

    /*public function loadFlights(): FlightEventCollection
    {
        if (!$this->authenticate()) {
            return new FlightEventCollection();
        }
    
        $eventModel = new FlightEventModel();
        $flightsData = $eventModel->getUserFlights($_SESSION[KWRD_USERID]);
    
        $flightCollection = new FlightEventCollection();
    
        foreach ($flightsData as $flightData) {
            $flightCollection->add((new FlightEventModel())->createModel($flightData));
        }
    
        return $flightCollection;
    }*/
    
    public function initAll($db, $userId, $planetId)
    {
        $db->insert('buildings', ['planetId' => $planetId]);
        $db->insert('ships', ['planetId' => $planetId]);
        $db->insert('defenses', ['planetId' => $planetId]);
        
        if ($userId != 0)
        {
            $db->insert('researches', ['userId' => $userId]);
        }
    }
}