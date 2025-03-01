<?php

namespace App\Models;

use App\Core\Loader;
use App\Core\Model;
use App\Interfaces\ModelInterface;
use Exception;

class BuildingQueueModel extends Model implements ModelInterface
{
    protected int $id;
    protected int $userId;
    protected int $planetId;
    protected int $queuePosition = 1;
    protected int $buildingId;
    protected int $buildingLevel;
    protected $startTime;
    protected $endTime;

    public function getBuildingQueue(): ?array
    {
        try
        {
            $query = "SELECT * From buildingQueue WHERE planetId = :planetId";
            $buildingQueueData = $this->db->fetchAll($query, [':planetId' => $this->getPlanetId()]);

            if ($buildingQueueData)
            {
                return $buildingQueueData;
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }

        return null;
    }

    public function getActiveQueue(): ?array
    {
        try
        {
            $query = "SELECT * From buildingQueue WHERE planetId = :planetId AND endTime > UNIX_TIMESTAMP()";
            $buildingQueueData = $this->db->fetchAll($query, [
                ':planetId' => $this->getPlanetId()]
            );

            if ($buildingQueueData)
            {
                return $buildingQueueData;
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }

        return null;
    }

    public function insertInQueue($data)
    {
        $this->db->executeQuery(
            'INSERT INTO buildingQueue (userId, planetId, queuePosition, buildingId, buildingLevel, startTime, endTime) 
             VALUES (:userId, :planetId, :queuePosition, :buildingId, :buildingLevel, FROM_UNIXTIME(:startTime), FROM_UNIXTIME(:endTime))',
            [
                'userId' => $data['userId'],
                'planetId' => $this->getPlanetId(),
                'queuePosition' => $data['queuePosition'],
                'buildingId' => $data['buildingId'],
                'buildingLevel' => $data['buildingLevel'],
                'startTime' => $data['startTime'], 
                'endTime' => $data['endTime']     
            ]
        );
    }

    public function getBuildingQueueCount()
    {
        return $this->db->fetchSingle(
            'SELECT COUNT(*) AS total FROM buildingQueue WHERE planetId = ?',
            [$this->getPlanetId()]
        )['total'];
    }

    public function getBuildingQueueLastEvent()
    {
        return $this->db->fetchSingle(
            'SELECT * FROM buildingQueue WHERE planetId = ? ORDER BY queuePosition DESC LIMIT 1',
            [$this->getPlanetId()]
        );
    }

    public function getBuildingMaxLevelInQueue(int $buildingId)
    {
        return $this->db->fetchSingle(
            'SELECT MAX(buildingLevel) AS maxLevel FROM buildingQueue WHERE planetId = ? AND buildingId = ? ORDER BY queuePosition DESC LIMIT 1',
            [$this->getPlanetId(), $buildingId]
        )['maxLevel'];
    }

    public function removeFromQueue($buildingId, $position, $level)
    {
        $this->db->delete(
            'buildingQueue',
            'planetId = :planetId AND buildingId = :buildingId AND (queuePosition = :position OR buildingLevel >= :level)',
            [
                'planetId' => $this->getPlanetId(),
                'buildingId' => $buildingId,
                'position' => $position,
                'level' => $level
            ]
        );
    }

    public function reorderQueue()
    {
        $queue = $this->db->fetchAll(
            'SELECT id FROM buildingQueue WHERE planetId = :planetId ORDER BY queuePosition ASC',
            ['planetId' => $this->getPlanetId()]
        );
    
        $position = 1;
        foreach ($queue as $item) {
            $this->db->executeQuery(
                'UPDATE buildingQueue SET queuePosition = :position WHERE id = :id',
                [
                    'position' => $position,
                    'id' => $item['id']
                ]
            );
            $position++;
        }
    }

    public function createModel($buildingQueueData): self
    {
        Loader::loadBuildingQueueData($this, $buildingQueueData);
        $this->setPlanetId($buildingQueueData['planetId']);
        return $this;
    }
}