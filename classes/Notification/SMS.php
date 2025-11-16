<?php

namespace classes\Notification;

class SMS implements NotificationInterface
{
    use LogMessageTrait;
    public string $phone;
    public string $message;
    public int $timestamp;
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function notify($msg)
    {
        $this->message = $msg;
        $this->timestamp = time();
        echo "Телефон : $this->phone<br>";
        echo "Сообщение: $msg<br>";
    }
}