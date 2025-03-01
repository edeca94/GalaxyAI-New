<?php

namespace App\Services\Cron;

use App\Core\LogManager;

use App\Core\Cron\EvaluateBuildingQueueCron;

class CronService
{
    protected array $jobs = [];
    protected LogManager $logger;

    public function __construct()
    {
        $this->jobs = [
            new EvaluateBuildingQueueCron(),
        ];

        $this->logger = new LogManager();
    }

    public function run()
    {
        $this->logger->write("CronService", "Avvio esecuzione cronjob.");

        foreach ($this->jobs as $job) {
            $className = (new \ReflectionClass($job))->getShortName();
            $this->logger->write("CronService", "Eseguendo {$className}...");
            $job->run();
        }

        $this->logger->write("CronService", "Tutti i cronjob completati.");
    }
}
