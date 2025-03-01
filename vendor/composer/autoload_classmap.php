<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return array(
    'App\\Collections\\BuildingQueueCollection' => $baseDir . '/App/Collections/BuildingQueueCollection.php',
    'App\\Collections\\FlightEventCollection' => $baseDir . '/App/Collections/FlightEventCollection.php',
    'App\\Collections\\MessageCollection' => $baseDir . '/App/Collections/MessageCollection.php',
    'App\\Controllers\\BuildingsController' => $baseDir . '/App/Controllers/BuildingsController.php',
    'App\\Controllers\\DefenseController' => $baseDir . '/App/Controllers/DefenseController.php',
    'App\\Controllers\\FacilitiesController' => $baseDir . '/App/Controllers/FacilitiesController.php',
    'App\\Controllers\\HomeController' => $baseDir . '/App/Controllers/HomeController.php',
    'App\\Controllers\\LogoutController' => $baseDir . '/App/Controllers/LogoutController.php',
    'App\\Controllers\\OverviewController' => $baseDir . '/App/Controllers/OverviewController.php',
    'App\\Controllers\\ResearchController' => $baseDir . '/App/Controllers/ResearchController.php',
    'App\\Controllers\\ShipyardController' => $baseDir . '/App/Controllers/ShipyardController.php',
    'App\\Core\\Authenticator' => $baseDir . '/App/Core/Authenticator.php',
    'App\\Core\\Controller' => $baseDir . '/App/Core/Abstract/Controller.php',
    'App\\Core\\Core' => $baseDir . '/App/Core/Core.php',
    'App\\Core\\CronJob' => $baseDir . '/App/Core/Abstract/CronJob.php',
    'App\\Core\\Cron\\EvaluateBuildingQueueCron' => $baseDir . '/App/Services/Crons/EvaluateBuildingQueueCron.php',
    'App\\Core\\Database' => $baseDir . '/App/Core/Database/Database.php',
    'App\\Core\\Loader' => $baseDir . '/App/Core/Loader.php',
    'App\\Core\\LogManager' => $baseDir . '/App/Core/LogManager.php',
    'App\\Core\\Model' => $baseDir . '/App/Core/Abstract/Model.php',
    'App\\Core\\Objects\\Building' => $baseDir . '/App/Objects/units/Building.php',
    'App\\Core\\Objects\\Unit' => $baseDir . '/App/Objects/Unit.php',
    'App\\Core\\Objects\\Units' => $baseDir . '/App/Objects/Units.php',
    'App\\Core\\PDOFactory' => $baseDir . '/App/Core/Database/PDOFactory.php',
    'App\\Core\\Router' => $baseDir . '/App/Core/Router.php',
    'App\\Core\\Translator' => $baseDir . '/App/Core/Translator.php',
    'App\\Enums\\EventMission' => $baseDir . '/App/Enums/EventMission.php',
    'App\\Enums\\EventStatus' => $baseDir . '/App/Enums/EventStatus.php',
    'App\\Enums\\EventType' => $baseDir . '/App/Enums/EventType.php',
    'App\\Helpers\\RequestHelper' => $baseDir . '/App/Helpers/RequestHelper.php',
    'App\\Interfaces\\ModelInterface' => $baseDir . '/App/Interfaces/ModelInterface.php',
    'App\\Models\\AllianceModel' => $baseDir . '/App/Models/AllianceModel.php',
    'App\\Models\\BuildingModel' => $baseDir . '/App/Models/BuildingModel.php',
    'App\\Models\\BuildingQueueModel' => $baseDir . '/App/Models/BuildingQueueModel.php',
    'App\\Models\\DefenseModel' => $baseDir . '/App/Models/DefenseModel.php',
    'App\\Models\\MessageModel' => $baseDir . '/App/Models/MessageModel.php',
    'App\\Models\\PlanetModel' => $baseDir . '/App/Models/PlanetModel.php',
    'App\\Models\\ShipModel' => $baseDir . '/App/Models/ShipModel.php',
    'App\\Models\\TechModel' => $baseDir . '/App/Models/TechModel.php',
    'App\\Models\\UserModel' => $baseDir . '/App/Models/UserModel.php',
    'App\\Services\\BuildingService' => $baseDir . '/App/Services/BuildingService.php',
    'App\\Services\\Cron\\CronService' => $baseDir . '/App/Services/CronService.php',
    'App\\Services\\EventService' => $baseDir . '/App/Services/EventService.php',
    'App\\Services\\LoaderService' => $baseDir . '/App/Services/LoaderService.php',
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
);
