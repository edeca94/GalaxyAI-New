<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitec9ec143a8332e9d6403a69a7783d7cb
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'App\\Collections\\MessageCollection' => __DIR__ . '/../..' . '/App/Collections/MessageCollection.php',
        'App\\Controllers\\BuildingsController' => __DIR__ . '/../..' . '/App/Controllers/BuildingsController.php',
        'App\\Controllers\\HomeController' => __DIR__ . '/../..' . '/App/Controllers/HomeController.php',
        'App\\Controllers\\LogoutController' => __DIR__ . '/../..' . '/App/Controllers/LogoutController.php',
        'App\\Controllers\\OverviewController' => __DIR__ . '/../..' . '/App/Controllers/OverviewController.php',
        'App\\Core\\Authenticator' => __DIR__ . '/../..' . '/App/Core/Authenticator.php',
        'App\\Core\\Controller' => __DIR__ . '/../..' . '/App/Core/Abstract/Controller.php',
        'App\\Core\\Core' => __DIR__ . '/../..' . '/App/Core/Core.php',
        'App\\Core\\Database' => __DIR__ . '/../..' . '/App/Core/Database/Database.php',
        'App\\Core\\Loader' => __DIR__ . '/../..' . '/App/Core/Loader.php',
        'App\\Core\\Model' => __DIR__ . '/../..' . '/App/Core/Abstract/Model.php',
        'App\\Core\\Objects\\Building' => __DIR__ . '/../..' . '/App/Objects/units/Building.php',
        'App\\Core\\Objects\\Unit' => __DIR__ . '/../..' . '/App/Objects/Unit.php',
        'App\\Core\\Objects\\Units' => __DIR__ . '/../..' . '/App/Objects/Units.php',
        'App\\Core\\PDOFactory' => __DIR__ . '/../..' . '/App/Core/Database/PDOFactory.php',
        'App\\Core\\Router' => __DIR__ . '/../..' . '/App/Core/Router.php',
        'App\\Core\\Translator' => __DIR__ . '/../..' . '/App/Core/Translator.php',
        'App\\Interfaces\\ModelInterface' => __DIR__ . '/../..' . '/App/Interfaces/ModelInterface.php',
        'App\\Models\\AllianceModel' => __DIR__ . '/../..' . '/App/Models/AllianceModel.php',
        'App\\Models\\BuildingModel' => __DIR__ . '/../..' . '/App/Models/BuildingModel.php',
        'App\\Models\\DefenseModel' => __DIR__ . '/../..' . '/App/Models/DefenseModel.php',
        'App\\Models\\MessageModel' => __DIR__ . '/../..' . '/App/Models/MessageModel.php',
        'App\\Models\\PlanetModel' => __DIR__ . '/../..' . '/App/Models/PlanetModel.php',
        'App\\Models\\ShipModel' => __DIR__ . '/../..' . '/App/Models/ShipModel.php',
        'App\\Models\\TechModel' => __DIR__ . '/../..' . '/App/Models/TechModel.php',
        'App\\Models\\UserModel' => __DIR__ . '/../..' . '/App/Models/UserModel.php',
        'App\\Services\\BuildingService' => __DIR__ . '/../..' . '/App/Services/BuildingService.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitec9ec143a8332e9d6403a69a7783d7cb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitec9ec143a8332e9d6403a69a7783d7cb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitec9ec143a8332e9d6403a69a7783d7cb::$classMap;

        }, null, ClassLoader::class);
    }
}
