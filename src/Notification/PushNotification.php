<?php

namespace App\Notification;

class PushNotification implements NotificationInterface
{
    public function send(string $message): void
    {
        echo "Push envoyé : $message" ;
    }

}
