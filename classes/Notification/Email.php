<?php

namespace classes\Notification;

class Email implements NotificationInterface
{
    use LogMessageTrait;
    public string $email;
    public string $message;
    public function __construct($email)
    {
        $this->email = $email;
    }
    public function notify($msg)
    {
        $this->message = $msg;
        echo "Email : $this->email<br>";
        echo "Сообщение: $msg<br>";
    }
}