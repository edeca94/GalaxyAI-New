<?php

namespace App\Collections;

use ArrayObject;

use App\Models\MessageModel;

class MessageCollection extends ArrayObject
{
    public function add(MessageModel $messageModel): void
    {
        $this->append($messageModel);
    }
}