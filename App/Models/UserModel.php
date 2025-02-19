<?php

namespace App\Models;

use Exception;

use App\Core\Loader;
use App\Core\Model;

class UserModel extends Model
{
    protected $userId;
    protected $userName;
    protected $userEmail;
    protected $userAuthLevel;
    protected $userHomePlanetId;
    protected $userCurrentPlanetId;
    protected $userLastIp;
    protected $userRegistrationIp;
    protected $userAgent;
    protected $userCurrentPage;
    protected $userRegistrationTime;
    protected $userOnlineTime;
    protected $userFleetShortcutId;
    protected $userAllyId;
    protected $userAllyRequest;
    protected $userAllyRequestText;
    protected $userAllyRegistrationTime;
    protected $userAllyRankId;
    protected $userIsBanned;

    public function registerUser($email, $username, $password): int
    {
        if (!$email || !$username || !$password)
        {
            $this->throwCustomErrorAjax($this->translator->translate('empty_fields'));
        }

        if ($this->usernameExists($username)) 
        {
            $this->throwCustomErrorAjax($this->translator->translate('user_exists'));
        }
        
        if ($this->emailExists($email)) 
        {
            $this->throwCustomErrorAjax($this->translator->translate('email_exists'));
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->insert('users',
            [
                'name' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'lastIp' => $_SERVER['REMOTE_ADDR'],
                'registrationIp' => $_SERVER['REMOTE_ADDR'],
                'agent' => $_SERVER['HTTP_USER_AGENT'],
                'registrationTime' => date('Y-m-d H:i:s'),
                'isBanned' => 0
            ]
        );

        $userId = $this->db->getLastInsertId();
        $this->setUserId($userId);
        return $userId;
    }

    public function login($email, $password): ?UserModel
    {
        if (!$email || !$password)
        {
            $this->throwCustomErrorAjax($this->translator->translate('empty_fields'));
        }

        try 
        {
            $query = "SELECT * FROM users WHERE email = :email";
            $userData = $this->db->fetchSingle($query, [':email' => $email]);

            if ($userData)
            {
                if (password_verify($password, $userData['password']))
                {
                    Loader::loadUserData($this, $userData);
                    return $this;
                }
                else
                {
                    $this->throwCustomErrorAjax($this->translator->translate('wrong_password'));
                }
            }
            else
            {
                $this->throwCustomErrorAjax($this->translator->translate('wrong_email'));
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return null;
    }

    public function getUserById(int $userId): ?array
    {
        try 
        {
            $query = "SELECT * FROM users WHERE id = :userId";
            $userData = $this->db->fetchSingle($query, [':userId' => $userId]);

            if ($userData) 
            {
                return $userData;
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

    private function usernameExists($username): bool 
    {
        $query = "SELECT COUNT(*) FROM users WHERE name = :name";
        $params = [':name' => $username];
        $statement = $this->db->executeQuery($query, $params);
        $count = $statement->fetchColumn();
        return $count > 0;
    }

    private function emailExists($email): bool 
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $params = [':email' => $email];
        $statement = $this->db->executeQuery($query, $params);
        $count = $statement->fetchColumn();
        return $count > 0;
    }

    public function updateMainPlanet($planetId): void
    {
        $this->db->update(
            'users',
            [
                'homePlanetId' => $planetId,
                'currentPlanetId' => $planetId
            ],
            'id = :userId',
            [':userId' => $this->getUserId()]
        );
    }

    public function updateCurrentPlanet($planetId): void
    {
        $this->db->update(
            'users',
            ['currentPlanetId' => $planetId],
            'id = :userId',
            [':userId' => $this->getUserId()]
        );
    }

    public function createModel(array $userData): self
    {
        Loader::loadUserData($this, $userData);
        return $this;
    }
}