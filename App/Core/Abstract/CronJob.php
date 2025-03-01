<?php

namespace App\Core;

use ReflectionClass;
use Exception;

abstract class CronJob
{
    protected string $cronName;
    protected string $lockFile;
    protected LogManager $logger;

    public function __construct()
    {
        $this->cronName = (new ReflectionClass($this))->getShortName();
        $this->lockFile = sys_get_temp_dir() . "/{$this->cronName}.lock";
        $this->logger = new LogManager();
    }

    public function run()
    {
        if ($this->isLocked()) {
            $this->logger->write($this->cronName, "Processo già in esecuzione, annullato.");
            return;
        }

        $this->lock();
        $startTime = microtime(true);
        $this->logger->write($this->cronName, "Inizio esecuzione.");

        try {
            $this->execute(); 
            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 3);
            $this->logger->write($this->cronName, "Esecuzione completata in {$executionTime} secondi.");
        } catch (Exception $e) {
            $this->logger->write($this->cronName, "Errore: " . $e->getMessage());
        } finally {
            $this->unlock();
        }
    }

    abstract protected function execute();

    private function lock()
    {
        file_put_contents($this->lockFile, getmypid());
    }

    private function isLocked(): bool
    {
        return file_exists($this->lockFile);
    }

    private function unlock()
    {
        if (file_exists($this->lockFile)) {
            unlink($this->lockFile);
            $this->logger->write($this->cronName, "Lock file rimosso.");
        }
    }
}
