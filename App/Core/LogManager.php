<?php

namespace App\Core;

class LogManager
{
    private string $logDir;
    private string $globalLogFile;

    public function __construct()
    {
        $this->logDir = __DIR__ . "/../../logs/cron/";
        $this->globalLogFile = $this->logDir . "cron_general.log";

        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }
    }

    public function write(string $cronName, string $message)
    {
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "[$timestamp] [$cronName] $message" . PHP_EOL;

        $cronLogFile = "{$this->logDir}{$cronName}.log";
        file_put_contents($cronLogFile, $logMessage, FILE_APPEND);

        file_put_contents($this->globalLogFile, $logMessage, FILE_APPEND);
    }
}
