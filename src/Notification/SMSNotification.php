<?php

namespace App\Notification;

class SMSNotification implements NotificationInterface
{
    public function send(string $message): void
    {
        echo "SMS envoyé : $message" ;
    }

}
