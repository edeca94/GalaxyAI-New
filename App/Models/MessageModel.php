<?php

namespace App\Models;

use Exception;

use App\Core\Loader;
use App\Core\Model;

class MessageModel extends Model
{
    protected $messageId;
    protected $messageSenderId;
    protected $messageReceiverId;
    protected $messageTime;
    protected $messageFrom;
    protected $messageSubject;
    protected $messageText;
    protected $messageRead;

    public function findMessagesByUserId(int $userId): ?array
    {
        try 
        {
            $query = "SELECT * FROM messages WHERE messageReceiverId = :userId";
            $messageData = $this->db->fetchAll($query, [':userId' => $userId]);

            if ($messageData) 
            {
                return $messageData;
            } 
            else 
            {
                //throw new Exception("Messages not found.");
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception($e->getMessage());
        }

        return null;
    }

    public function countUnreadMessages(int $userId): int
    {    
        try {
            $query = "SELECT COUNT(*) FROM messages WHERE messageReceiverId = :messageReceiverId AND messageRead = 0";
            $unreadMessagesCount = $this->db->fetchColumn($query, [':messageReceiverId' => $userId]);
    
            return $unreadMessagesCount;
        } 
        catch (Exception $e) 
        {
            throw new Exception($e->getMessage());
        }
    }

    public function readAll($userId): void
    {
        $this->db->update(
            'messages',
            ['messageRead' => 1],
            'messageReceiverId = :userId',
            [':userId' => $userId]
        );
    }

    public function createModel($messageData): ?MessageModel
    {
        Loader::loadMessageData($this, $messageData);
        return $this;
    }
}