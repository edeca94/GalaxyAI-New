<?php

namespace App\Services;

use App\Core\Authenticator;

use App\Models\MessageModel;
use App\Models\UserModel;
use App\Models\PlanetModel;

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

        return $baseData;
    }
    
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