<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\Cron\CronService;

$cronService = new CronService();
$cronService->run();