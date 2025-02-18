<?php

namespace App\Core;

use App\Models\UserModel;
use App\Models\PlanetModel;
use App\Models\BuildingModel;
use App\Models\TechModel;
use App\Models\ShipModel;
use App\Models\DefenseModel;
use App\Models\MessageModel;
use App\Models\AllianceModel;

class Loader 
{
    public static function loadUserData(UserModel $userModel, array $userData): void
    {
        $userModel->setUserId($userData['id']);
        $userModel->setUserName($userData['name']);
        $userModel->setUserEmail($userData['email']);
        $userModel->setUserAuthLevel($userData['authLevel']);
        $userModel->setUserHomePlanetId($userData['homePlanetId']);
        $userModel->setUserCurrentPlanetId($userData['currentPlanetId']);
        $userModel->setUserLastIp($userData['lastIp']);
        $userModel->setUserRegistrationIp($userData['registrationIp']);
        $userModel->setUserAgent($userData['agent']);
        $userModel->setUserCurrentPage($userData['currentPage']);
        $userModel->setUserRegistrationTime($userData['registrationTime']);
        $userModel->setUserOnlineTime($userData['onlineTime']);
        $userModel->setUserFleetShortcutId($userData['fleetShortcutId']);
        $userModel->setUserAllyId($userData['allyId']);
        $userModel->setUserAllyRequest($userData['allyRequest']);
        $userModel->setUserAllyRequestText($userData['allyRequestText']);
        $userModel->setUserAllyRegistrationTime($userData['allyRegistrationTime']);
        $userModel->setUserAllyRankId($userData['allyRankId']);
        $userModel->setUserIsBanned($userData['isBanned']);
    }

    public static function loadPlanetData(PlanetModel $planetModel, array $planetData): void
    {
        $planetModel->setPlanetId($planetData['id']);
        $planetModel->setPlanetName($planetData['name']);
        $planetModel->setPlanetGalaxy($planetData['galaxy']);
        $planetModel->setPlanetSystem($planetData['system']);
        $planetModel->setPlanetPosition($planetData['position']);
        $planetModel->setPlanetFields($planetData['fields']);
        $planetModel->setPlanetTotalFields($planetData['totalFields']);
        $planetModel->setPlanetDiameter($planetData['diameter']);
        $planetModel->setPlanetMinTemp($planetData['minTemp']);
        $planetModel->setPlanetMaxTemp($planetData['maxTemp']);
        $planetModel->setPlanetMetal($planetData['metal']);
        $planetModel->setPlanetMetalPerHour($planetData['metalPerHour']);
        $planetModel->setPlanetCrystal($planetData['crystal']);
        $planetModel->setPlanetCrystalPerHour($planetData['crystalPerHour']);
        $planetModel->setPlanetDeuterium($planetData['deuterium']);
        $planetModel->setPlanetDeuteriumPerHour($planetData['deuteriumPerHour']);
        $planetModel->setPlanetEnergyUsed($planetData['energyUsed']);
        $planetModel->setPlanetEnergyMax($planetData['energyMax']);
        $planetModel->setPlanetMetalMinePercent($planetData['metalMinePercent']);
        $planetModel->setPlanetCrystalMinePercent($planetData['crystalMinePercent']);
        $planetModel->setPlanetDeuteriumSynthesizerPercent($planetData['deuteriumSynthesizerPercent']);
        $planetModel->setPlanetSolarPlantPercent($planetData['solarPlantPercent']);
        $planetModel->setPlanetFusionReactorPercent($planetData['fusionReactorPercent']);
        $planetModel->setPlanetSolarSatellitePercent($planetData['solarSatellitePercent']);
        $planetModel->setPlanetLastJumpTime($planetData['lastJumpTime']);
        $planetModel->setPlanetDestroyed($planetData['destroyed']);
        $planetModel->setPlanetDebrisMetal($planetData['debrisMetal']);
        $planetModel->setPlanetDebrisCrystal($planetData['debrisCrystal']);
    }

    public static function loadBuildingData(BuildingModel $buildingModel, array $buildingData): void
    {
        $buildingModel->setId($buildingData['id']);
        $buildingModel->setPlanetId($buildingData['planetId']);
        $buildingModel->setMetalMine($buildingData['metalMine']);
        $buildingModel->setCrystalMine($buildingData['crystalMine']);
        $buildingModel->setDeuteriumSynthesizer($buildingData['deuteriumSynthesizer']);
        $buildingModel->setSolarPlant($buildingData['solarPlant']);
        $buildingModel->setFusionReactor($buildingData['fusionReactor']);
        $buildingModel->setRobotFactory($buildingData['robotFactory']);
        $buildingModel->setNaniteFactory($buildingData['naniteFactory']);
        $buildingModel->setHangar($buildingData['hangar']);
        $buildingModel->setMetalStore($buildingData['metalStore']);
        $buildingModel->setCrystalStore($buildingData['crystalStore']);
        $buildingModel->setDeuteriumTank($buildingData['deuteriumTank']);
        $buildingModel->setResearchLab($buildingData['researchLab']);
        $buildingModel->setUniversity($buildingData['university']);
        $buildingModel->setTerraformer($buildingData['terraformer']);
        $buildingModel->setAllianceDepot($buildingData['allianceDepot']);
        $buildingModel->setMissileBase($buildingData['missileBase']);
        $buildingModel->setLunarOutpost($buildingData['lunarOutpost']);
        $buildingModel->setPhalanx($buildingData['phalanx']);
        $buildingModel->setHyperspacePortal($buildingData['hyperspacePortal']);
    }

    public static function loadTechData(TechModel $techModel, array $techData): void
    {        
        $techModel->setId($techData['id']);
        $techModel->setUserId($techData['userId']);
        $techModel->setEspionageTech($techData['espionageTech']);
        $techModel->setComputerTech($techData['computerTech']);
        $techModel->setWeaponTech($techData['weaponTech']);
        $techModel->setArmourTech($techData['armourTech']);
        $techModel->setShieldingTech($techData['shieldingTech']);
        $techModel->setEnergyTech($techData['energyTech']);
        $techModel->setHyperspaceTech($techData['hyperspaceTech']);
        $techModel->setCombustionDriveTech($techData['combustionDriveTech']);
        $techModel->setImpulseDriveTech($techData['impulseDriveTech']);
        $techModel->setHyperspaceDriveTech($techData['hyperspaceDriveTech']);
        $techModel->setLaserTech($techData['laserTech']);
        $techModel->setIonTech($techData['ionTech']);
        $techModel->setPlasmaTech($techData['plasmaTech']);
        $techModel->setIntergalacticResearchTech($techData['intergalacticResearchTech']);
        $techModel->setGravitonTech($techData['gravitonTech']);
    }
    
    public static function loadShipData(ShipModel $shipModel, array $shipData): void
    {
        $shipModel->setId($shipData['id']);
        $shipModel->setPlanetId($shipData['planetId']);
        $shipModel->setSmallCargo($shipData['smallCargo']);
        $shipModel->setLargeCargo($shipData['largeCargo']);
        $shipModel->setLightFighter($shipData['lightFighter']);
        $shipModel->setHeavyFighter($shipData['heavyFighter']);
        $shipModel->setCruiser($shipData['cruiser']);
        $shipModel->setBattleship($shipData['battleship']);
        $shipModel->setColonyShip($shipData['colonyShip']);
        $shipModel->setRecycler($shipData['recycler']);
        $shipModel->setEspionageProbe($shipData['espionageProbe']);
        $shipModel->setBomber($shipData['bomber']);
        $shipModel->setSolarSatellite($shipData['solarSatellite']);
        $shipModel->setDestroyer($shipData['destroyer']);
        $shipModel->setDeathStar($shipData['deathStar']);
        $shipModel->setBattlecruiser($shipData['battlecruiser']);
    }

    public static function loadDefenseData(DefenseModel $defenseModel, array $defenseData): void
    {
        $defenseModel->setId($defenseData['id']);
        $defenseModel->setPlanetId($defenseData['planetId']);
        $defenseModel->setRocketLauncher($defenseData['rocketLauncher']);
        $defenseModel->setLightLaser($defenseData['lightLaser']);
        $defenseModel->setHeavyLaser($defenseData['heavyLaser']);
        $defenseModel->setGaussCannon($defenseData['gaussCannon']);
        $defenseModel->setIonCannon($defenseData['ionCannon']);
        $defenseModel->setPlasmaTurret($defenseData['plasmaTurret']);
        $defenseModel->setSmallShieldDome($defenseData['smallShieldDome']);
        $defenseModel->setLargeShieldDome($defenseData['largeShieldDome']);
        $defenseModel->setAntiBallisticMissile($defenseData['antiBallisticMissile']);
        $defenseModel->setInterplanetaryMissile($defenseData['interplanetaryMissile']);
    }

    public static function loadMessageData(MessageModel $messageModel, array $messageData): void
    {
        $messageModel->setMessageId($messageData['id']);
        $messageModel->setMessageSenderId($messageData['messageSenderId']);
        $messageModel->setMessageReceiverId($messageData['messageReceiverId']);
        $messageModel->setMessageTime($messageData['messageTime']);
        $messageModel->setMessageFrom($messageData['messageFrom']);
        $messageModel->setMessageSubject($messageData['messageSubject']);
        $messageModel->setMessageText($messageData['messageText']);
        $messageModel->setMessageRead($messageData['messageRead']);
    }

    public static function loadAllianceData(AllianceModel $allianceModel, array $allianceData): void
    {
        $allianceModel->setId($allianceData['id']);
        $allianceModel->setAllianceName($allianceData['allianceName']);
        $allianceModel->setAllianceTag($allianceData['allianceTag']);
        $allianceModel->setAllianceOwnerId($allianceData['allianceOwnerId']);
        $allianceModel->setAllianceRegisterTime($allianceData['allianceRegisterTime']);
        $allianceModel->setAllianceDescription($allianceData['allianceDescription']);
        $allianceModel->setAllianceWebsite($allianceData['allianceWebsite']);
        $allianceModel->setAllianceText($allianceData['allianceText']);
        $allianceModel->setAllianceImage($allianceData['allianceImage']);
        $allianceModel->setAllianceRequestDefaultText($allianceData['allianceRequestDefaultText']);
        $allianceModel->setAllianceClosed($allianceData['allianceClosed']);
        $allianceModel->setAllianceRanks($allianceData['allianceRanks']);
    }

    public static function loadBaseData(): array
    {
        $baseData = array();

        $userModel = new UserModel();
        $userData = $userModel->getUserById($_SESSION[KWRD_USERID]);
        $baseData['user'] = $userModel->createModel($userData);

        $planetModel = new PlanetModel();
        $planetData = $planetModel->getPlanetById($userModel->getUserCurrentPlanetId());
        $baseData['planet'] = $planetModel->createModel($planetData);

        return $baseData;
    }

    public static function initAll($db, $userId, $planetId)
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