<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProximityAlert extends Notification
{
    use Queueable;

    public function __construct(
        public float $distance,
        public bool $withinRange,
        public float $lat,
        public float $lng
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Proximity Alert')
            ->line('Distance: ' . round($this->distance, 2) . ' meters')
            ->line('Within Range: ' . ($this->withinRange ? 'Yes' : 'No'))
            ->line('Delivery: ' . $this->lat . ', ' . $this->lng)
            ->line('This is a development email written to your log.');
    }
}

