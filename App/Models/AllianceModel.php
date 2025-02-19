<?php

namespace App\Models;

use App\Core\Loader;
use App\Core\Model;

use App\Interfaces\ModelInterface;

use Exception;

class AllianceModel extends Model implements ModelInterface
{
    protected $id;
    protected $allianceName;
    protected $allianceTag;
    protected $allianceOwnerId;
    protected $allianceRegisterTime;
    protected $allianceDescription;
    protected $allianceWebsite;
    protected $allianceText;
    protected $allianceImage;
    protected $allianceRequestDefaultText;
    protected $allianceClosed;
    protected $allianceRanks;

    public function findAllyByUserId(int $userId): ?array
    {
        try 
        {
            $userModel = new UserModel();
            $userModel->createUserModel($userId);

            $allyId = $userModel->getUserAllyId();

            if (!$allyId) 
            {
                return null;
            }

            $query = "SELECT * FROM alliances WHERE id = :allyId";
            $allyData = $this->db->fetchSingle($query, [':allyId' => $allyId]);

            if ($allyData) 
            {
                return $allyData;
            } 
            else 
            {
                //throw new Exception("Alliance not found.");
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception($e->getMessage());
        }

        return null;
    }

    public function createModel(array $allianceData): self
    {
        Loader::loadAllianceData($this, $allianceData);
        return $this;
    }
}