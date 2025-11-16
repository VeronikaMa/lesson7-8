<?php

namespace classes\Notification;

trait LogMessageTrait
{
    public function logMessageToDB(){
        print_r($this->message);
    }

    public function getSendTime(){
        print_r("Время отправки сообщения: $this->timestamp <br>");
    }
}