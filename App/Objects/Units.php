<?php

namespace App\Core\Objects;

use App\Core\Translator;

class Units
{
    private static $units;
    private static $names;
    private static $descriptions;
    private static $priceList;
    private static $requeriments;

    static function init(Translator $translator)
    {
        self::$units = [
            1   => 'metalMine',
            2   => 'crystalMine',
            3   => 'deuteriumSynthesizer',
            4   => 'solarPlant',
            5   => 'fusionReactor',
            6   => 'metalStore',
            7   => 'crystalStore',
            8   => 'deuteriumTank',
            9   => 'robotFactory',
            10  => 'naniteFactory',
            11  => 'hangar',
            12  => 'researchLab',
            13  => 'terraformer',
            14  => 'allianceDepot',
            15  => 'missileBase',
        
            101 => 'espionageTech',
            102 => 'computerTech',
            103 => 'weaponTech',
            104 => 'armourTech',
            105 => 'shieldingTech',
            106 => 'energyTech',
            107 => 'hyperspaceTech',
            108 => 'combustionDriveTech',
            109 => 'impulseDriveTech',
            110 => 'hyperspaceDriveTech',
            111 => 'laserTech',
            112 => 'ionTech',
            113 => 'plasmaTech',
            114 => 'intergalacticResearchTech',
            115 => 'gravitonTech',
        
            201 => 'smallCargo',
            202 => 'largeCargo',
            203 => 'lightFighter',
            204 => 'heavyFighter',
            205 => 'cruiser',
            206 => 'battleship',
            207 => 'colonyShip',
            208 => 'recycler',
            209 => 'espionageProbe',
            210 => 'bomber',
            211 => 'solarSatellite',
            212 => 'destroyer',
            213 => 'battlecruiser',
            214 => 'deathstar',
        
            301 => 'rocketLauncher',
            302 => 'lightLaser',
            303 => 'heavyLaser',
            304 => 'gaussCannon',
            305 => 'ionCannon',
            306 => 'plasmaTurret',
            307 => 'smallShieldDome',
            308 => 'largeShieldDome',
            309 => 'antiBallisticMissile',
            310 => 'interplanetaryMissile'
        ];

        self::$names = [
            1  => $translator->translate('metal_mine'),
            2  => $translator->translate('crystal_mine'),
            3  => $translator->translate('deuterium_synthesizer'),
            4  => $translator->translate('solar_plant'),
            5  => $translator->translate('fusion_reactor'),
            6  => $translator->translate('metal_store'),
            7  => $translator->translate('crystal_store'),
            8  => $translator->translate('deuterium_tank'),
            9  => $translator->translate('robot_factory'),
            10 => $translator->translate('nanite_factory'),
            11 => $translator->translate('hangar'),
            12 => $translator->translate('research_lab'),
            13 => $translator->translate('terraformer'),
            14 => $translator->translate('alliance_depot'),
            15 => $translator->translate('missile_silo'),

            101 => $translator->translate('espionage_tech'),
            102 => $translator->translate('computer_tech'),
            103 => $translator->translate('weapon_tech'),
            104 => $translator->translate('armour_tech'),
            105 => $translator->translate('shielding_tech'),
            106 => $translator->translate('energy_tech'),
            107 => $translator->translate('hyperspace_tech'),
            108 => $translator->translate('combustion_drive_tech'),
            109 => $translator->translate('impulse_drive_tech'),
            110 => $translator->translate('hyperspace_drive_tech'),
            111 => $translator->translate('laser_tech'),
            112 => $translator->translate('ion_tech'),
            113 => $translator->translate('plasma_tech'),
            114 => $translator->translate('intergalactic_research_tech'),
            115 => $translator->translate('graviton_tech'),

            201 => $translator->translate('small_cargo_ship'),
            202 => $translator->translate('large_cargo_ship'),
            203 => $translator->translate('light_fighter'),
            204 => $translator->translate('heavy_fighter'),
            205 => $translator->translate('cruiser'),
            206 => $translator->translate('battleship'),
            207 => $translator->translate('colony_ship'),
            208 => $translator->translate('recycler'),
            209 => $translator->translate('espionage_probe'),
            210 => $translator->translate('bomber'),
            211 => $translator->translate('solar_satellite'),
            212 => $translator->translate('destroyer'),
            213 => $translator->translate('battlecruiser'),
            214 => $translator->translate('deathstar'),

            301 => $translator->translate('rocket_launcher'),
            302 => $translator->translate('light_laser'),
            303 => $translator->translate('heavy_laser'),
            304 => $translator->translate('gauss_cannon'),
            305 => $translator->translate('ion_cannon'),
            306 => $translator->translate('plasma_turret'),
            307 => $translator->translate('small_shield_dome'),
            308 => $translator->translate('large_shield_dome'),
            309 => $translator->translate('anti_ballistic_missile'),
            310 => $translator->translate('interplanetary_missile')
        ];

        self::$descriptions = [
            1  => $translator->translate('metal_mine_descr'),
            2  => $translator->translate('crystal_mine_descr'),
            3  => $translator->translate('deuterium_synthesizer_descr'),
            4  => $translator->translate('solar_plant_descr'),
            5  => $translator->translate('fusion_reactor_descr'),
            6  => $translator->translate('metal_storage_descr'),
            7  => $translator->translate('crystal_storage_descr'),
            8  => $translator->translate('deuterium_storage_descr'),
            9  => $translator->translate('robot_factory_descr'),
            10 => $translator->translate('nanite_factory_descr'),
            11 => $translator->translate('hangar'),
            12 => $translator->translate('research_lab_descr'),
            13 => $translator->translate('terraformer_descr'),
            14 => $translator->translate('alliance_depot_descr'),
            15 => $translator->translate('missile_silo_descr'),

            101 => $translator->translate('espionage_tech_descr'),
            102 => $translator->translate('computer_tech_descr'),
            103 => $translator->translate('weapon_tech_descr'),
            104 => $translator->translate('armour_tech_descr'),
            105 => $translator->translate('shielding_tech_descr'),
            106 => $translator->translate('energy_tech_descr'),
            107 => $translator->translate('hyperspace_tech_descr'),
            108 => $translator->translate('combustion_drive_tech_descr'),
            109 => $translator->translate('impulse_drive_tech_descr'),
            110 => $translator->translate('hyperspace_drive_tech_descr'),
            111 => $translator->translate('laser_tech_descr'),
            112 => $translator->translate('ion_tech_descr'),
            113 => $translator->translate('plasma_tech_descr'),
            114 => $translator->translate('intergalactic_research_tech_descr'),
            115 => $translator->translate('graviton_tech_descr'),

            201 => $translator->translate('small_cargo_ship_descr'),
            202 => $translator->translate('large_cargo_ship_descr'),
            203 => $translator->translate('light_fighter_descr'),
            204 => $translator->translate('heavy_fighter_descr'),
            205 => $translator->translate('cruiser_descr'),
            206 => $translator->translate('battleship_descr'),
            207 => $translator->translate('colony_ship_descr'),
            208 => $translator->translate('recycler_descr'),
            209 => $translator->translate('espionage_probe_descr'),
            210 => $translator->translate('bomber_descr'),
            211 => $translator->translate('solar_satellite_descr'),
            212 => $translator->translate('destroyer_descr'),
            213 => $translator->translate('battlecruiser_descr'),
            214 => $translator->translate('deathstar_descr'),

            301 => $translator->translate('rocket_launcher_desc'),
            302 => $translator->translate('light_laser_desc'),
            303 => $translator->translate('heavy_laser_desc'),
            304 => $translator->translate('gauss_cannon_desc'),
            305 => $translator->translate('ion_cannon_desc'),
            306 => $translator->translate('plasma_turret_desc'),
            307 => $translator->translate('small_shield_dome_desc'),
            308 => $translator->translate('large_shield_dome_desc'),
            309 => $translator->translate('anti_ballistic_missile_desc'),
            310 => $translator->translate('interplanetary_missile_desc')
        ];

        self::$priceList = [
            // Buildings
            1   => ['metal' => 60, 'crystal' => 15, 'deuterium' => 0, 'energy' => 0, 'factor' => 1.5],
            2   => ['metal' => 48, 'crystal' => 24, 'deuterium' => 0, 'energy' => 0, 'factor' => 1.6],
            3   => ['metal' => 225, 'crystal' => 75, 'deuterium' => 0, 'energy' => 0, 'factor' => 1.5],
            4   => ['metal' => 75, 'crystal' => 30, 'deuterium' => 0, 'energy' => 0, 'factor' => 1.5],
            5   => ['metal' => 900, 'crystal' => 360, 'deuterium' => 180, 'energy' => 0, 'factor' => 1.8],
            6   => ['metal' => 1000, 'crystal' => 0, 'deuterium' => 0, 'energy' => 0, 'factor' => 2],
            7   => ['metal' => 1000, 'crystal' => 500, 'deuterium' => 0, 'energy' => 0, 'factor' => 2],
            8   => ['metal' => 1000, 'crystal' => 1000, 'deuterium' => 0, 'energy' => 0, 'factor' => 2],
            9   => ['metal' => 400, 'crystal' => 120, 'deuterium' => 200, 'energy' => 0, 'factor' => 2],
            10  => ['metal' => 1000000, 'crystal' => 500000, 'deuterium' => 100000, 'energy' => 0, 'factor' => 2],
            11  => ['metal' => 400, 'crystal' => 200, 'deuterium' => 100, 'energy' => 0, 'factor' => 2],
            12  => ['metal' => 200, 'crystal' => 400, 'deuterium' => 200, 'energy' => 0, 'factor' => 2],
            13  => ['metal' => 0, 'crystal' => 50000, 'deuterium' => 100000, 'energy' => 1000, 'factor' => 2],
            14  => ['metal' => 20000, 'crystal' => 40000, 'deuterium' => 0, 'energy' => 0, 'factor' => 2],
            15  => ['metal' => 20000, 'crystal' => 20000, 'deuterium' => 1000, 'energy' => 0, 'factor' => 2],

            // Techs
            101 => ['metal' => 200, 'crystal' => 1000, 'deuterium' => 200, 'energy' => 0, 'factor' => 2],
            102 => ['metal' => 0, 'crystal' => 400, 'deuterium' => 600, 'energy' => 0, 'factor' => 2],
            103 => ['metal' => 800, 'crystal' => 200, 'deuterium' => 0, 'energy' => 0, 'factor' => 2],
            104 => ['metal' => 200, 'crystal' => 600, 'deuterium' => 0, 'energy' => 0, 'factor' => 2],
            105 => ['metal' => 1000, 'crystal' => 0, 'deuterium' => 0, 'energy' => 0, 'factor' => 2],
            106 => ['metal' => 0, 'crystal' => 800, 'deuterium' => 400, 'energy' => 0, 'factor' => 2],
            107 => ['metal' => 0, 'crystal' => 4000, 'deuterium' => 2000, 'energy' => 0, 'factor' => 2],
            108 => ['metal' => 400, 'crystal' => 0, 'deuterium' => 600, 'energy' => 0, 'factor' => 2],
            109 => ['metal' => 2000, 'crystal' => 4000, 'deuterium' => 600, 'energy' => 0, 'factor' => 2],
            110 => ['metal' => 10000, 'crystal' => 20000, 'deuterium' => 6000, 'energy' => 0, 'factor' => 2],
            111 => ['metal' => 200, 'crystal' => 100, 'deuterium' => 0, 'energy' => 0, 'factor' => 2],
            112 => ['metal' => 1000, 'crystal' => 300, 'deuterium' => 100, 'energy' => 0, 'factor' => 2],
            113 => ['metal' => 2000, 'crystal' => 4000, 'deuterium' => 1000, 'energy' => 0, 'factor' => 2],
            114 => ['metal' => 240000, 'crystal' => 400000, 'deuterium' => 160000, 'energy' => 0, 'factor' => 2],
            115 => ['metal' => 0, 'crystal' => 0, 'deuterium' => 0, 'energy' => 300000, 'factor' => 3],

            // Fleet
            201 => ['metal'       => 2000,
                    'crystal'     => 2000,
                    'deuterium'   => 0,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 20,
                    'speed'       => 28000,
                    'capacity'    => 5000
            ],
            202 => ['metal'       => 6000,
                    'crystal'     => 6000,
                    'deuterium'   => 0,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 50,
                    'speed'       => 17250,
                    'capacity'    => 25000
            ],
            203 => ['metal'       => 3000,
                    'crystal'     => 1000,
                    'deuterium'   => 0,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 20,
                    'speed'       => 28750,
                    'capacity'    => 50
            ],
            204 => ['metal'       => 6000,
                    'crystal'     => 4000,
                    'deuterium'   => 0,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 75,
                    'speed'       => 28000,
                    'capacity'    => 100
            ],
            205 => ['metal'       => 20000,
                    'crystal'     => 7000,
                    'deuterium'   => 2000,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 300,
                    'speed'       => 42000,
                    'capacity'    => 800
            ],
            206 => ['metal'       => 45000,
                    'crystal'     => 15000,
                    'deuterium'   => 0,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 500,
                    'speed'       => 31000,
                    'capacity'    => 1500
            ],
            207 => ['metal' => 10000, 'crystal' => 20000, 'deuterium' => 10000, 'energy' => 0, 'factor' => 1],
            208 => ['metal'       => 10000,
                    'crystal'     => 6000,
                    'deuterium'   => 2000,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 300,
                    'speed'       => 4600,
                    'capacity'    => 20000
            ],
            209 => ['metal'       => 0,
                    'crystal'     => 1000,
                    'deuterium'   => 0,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 1,
                    'speed'       => 230000000,
                    'capacity'    => 5
            ],
            210 => ['metal'       => 50000,
                    'crystal'     => 25000,
                    'deuterium'   => 15000,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 1000,
                    'speed'       => 11200,
                    'capacity'    => 500
            ],
            211 => ['metal' => 0, 'crystal' => 2000, 'deuterium' => 500, 'energy' => 0, 'factor' => 1],
            212 => ['metal'       => 60000,
                    'crystal'     => 50000,
                    'deuterium'   => 15000,
                    'energy'      => 0,
                    'factor'      => 1,
                    'consumption' => 1000,
                    'speed'       => 15500,
                    'capacity'    => 2000
            ],
            213 => ['metal' => 30000, 'crystal' => 40000, 'deuterium' => 15000, 'energy' => 0, 'factor' => 1],
            214 => ['metal' => 5000000, 'crystal' => 4000000, 'deuterium' => 1000000, 'energy' => 0, 'factor' => 1],

            // Defense
            301 => ['metal' => 2000, 'crystal' => 0, 'deuterium' => 0, 'energy' => 0, 'factor' => 1],
            302 => ['metal' => 1500, 'crystal' => 500, 'deuterium' => 0, 'energy' => 0, 'factor' => 1],
            303 => ['metal' => 6000, 'crystal' => 2000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1],
            304 => ['metal' => 20000, 'crystal' => 15000, 'deuterium' => 2000, 'energy' => 0, 'factor' => 1],
            305 => ['metal' => 2000, 'crystal' => 6000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1],
            306 => ['metal' => 50000, 'crystal' => 50000, 'deuterium' => 30000, 'energy' => 0, 'factor' => 1],
            307 => ['metal' => 10000, 'crystal' => 10000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1],
            308 => ['metal' => 50000, 'crystal' => 50000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1],
            309 => ['metal' => 8000, 'crystal' => 2000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1],
            310 => ['metal' => 12500, 'crystal' => 2500, 'deuterium' => 10000, 'energy' => 0, 'factor' => 1]
        ];

        self::$requeriments = [
            // buildings
            5   => [3 => 5, 106 => 3],
            10  => [9 => 10, 102 => 10],
            11  => [9 => 2],
            13  => [7 => 1, 106 => 12],

            // techs
            101 => [12 => 3],
            102 => [12 => 1],
            103 => [12 => 4],
            104 => [12 => 2],
            105 => [12 => 6, 106 => 3],
            106 => [12 => 1],
            107 => [12 => 7, 106 => 5, 105 => 5],
            108 => [12 => 1, 106 => 1],
            109 => [12 => 2, 106 => 1],
            110 => [12 => 7, 107 => 3],
            111 => [12 => 1, 106 => 2],
            112 => [12 => 4, 106 => 4, 111 => 5],
            113 => [12 => 4, 106 => 8, 111 => 10, 112 => 5],
            114 => [12 => 10, 102 => 8, 107 => 8],
            115 => [12 => 12],

            // fleet
            201 => [8 => 2, 108 => 2],
            202 => [8 => 4, 108 => 6],
            203 => [8 => 1, 108 => 1],
            204 => [8 => 3, 104 => 2, 109 => 2],
            205 => [8 => 5, 109 => 4, 112 => 2],
            206 => [8 => 7, 110 => 4],
            207 => [8 => 4, 109 => 3],
            208 => [8 => 4, 108 => 6, 105 => 2],
            209 => [8 => 3, 108 => 3, 101 => 2],
            210 => [8 => 8, 109 => 6, 113 => 5],
            211 => [8 => 1],
            212 => [8 => 9, 107 => 5, 110 => 6],
            213 => [8 => 8, 111 => 12, 107 => 5, 110 => 5],
            214 => [8 => 12, 115 => 1, 107 => 6, 110 => 7]
        ];
    }

    static function getUnitId(string $unitName): int
    {
        return array_keys(self::$units, $unitName)[0];
    }

    static function getUnitName($id): string
    {
        if (isset(self::$units[$id])) 
        {
            return self::$units[$id];
        }

        return "";
    }

    static function getResources(): array
    {
        return array_slice(self::$units, 0, 8, true);
    }

    static function getFacilities(): array
    {
        return array_slice(self::$units, 8, 7, true);
    }

    static function getTechnologies(): array
    {
        return array_slice(self::$units, 15, 15, true);
    }

    static function getFleet(): array
    {
        return array_slice(self::$units, 30, 14, true);
    }
        
    static function getDefense(): array
    {
        return array_slice(self::$units, 44, 10, true);
    }

    static function getName(int $id): string
    {
        if (isset(self::$names[$id]))
        {
            return self::$names[$id];
        }

        return "";
    }

    static function getDescription(int $id): string
    {
        if (isset(self::$descriptions[$id]))
        {
            return self::$descriptions[$id];
        }

        return "";
    }

    static function getPriceList(int $id): array
    {
        if (isset(self::$priceList))
        {
            return self::$priceList[$id];
        }

        return [];
    }

    static function getRequirements(int $id): array
    {
        if (isset(self::$requeriments[$id]))
        {
            return self::$requeriments[$id];
        }

        return [];
    }

    static function getBuildingTime(Unit $unit, int $robotLvl, int $hangarLvl, int $naniteLvl, int $researchLabLvl) : float 
    {
        if($robotLvl < 0 || $hangarLvl < 0 || $naniteLvl < 0) {
            return -1.0;
        }
    
        $metal = $unit->getCostMetal();
        $crystal = $unit->getCostCrystal();
    
        if ($unit->getUnitId() < 100) {
            return (($metal + $crystal) / 2500) * (1 / (1 + $robotLvl)) * (1 / 10) * pow(2, -$naniteLvl);
        }
    
        if ($unit->getUnitId() > 100 && $unit->getUnitId() < 200) {
            return (($metal + $crystal) / 1000) * (1 + ($researchLabLvl * 10));
        }
    
        if ($unit->getUnitId() > 200 && $unit->getUnitId() < 400) {
            return (($metal + $crystal) / 2500) * (1 / (1 + $hangarLvl)) * (1 / 10) * pow(2, -$naniteLvl);
        }
    
        return -1.0;
    }
}