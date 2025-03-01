<?php

namespace App\Core\Cron;

use App\Core\CronJob;
use App\Services\EventService;

class EvaluateBuildingQueueCron extends CronJob
{
    protected function execute()
    {
        $this->logger->write($this->cronName, "Avvio smaltimento code di costruzione...");

        $service = new EventService();
        $log = $service->evaluateQueue();

        $this->logger->write($this->cronName, implode($log));
        $this->logger->write($this->cronName, "Code di costruzione processate.");
    }
}