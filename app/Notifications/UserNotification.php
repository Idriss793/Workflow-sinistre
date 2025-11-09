<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;
    protected $userType;
    protected $data;
    /**
     * Create a new notification instance.
     */
    public function __construct($userType, $data)
    {
        //
        $this->userType = $userType;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        switch ($this->userType) {
            case 'expert':
                return (new MailMessage)
                    ->subject('Expert Notifcation')
                    ->line("Le sinistre #{$this->data['num_sin']} vous a été attribué.");
            case 'gestionnaire':
                return (new MailMessage)
                    ->subject('UseGestionnaire Notification')
                    ->line("Le sinistre #{$this->data['num_sin']} est {$this->data['status']}.");
            case 'responsable':
                return (new MailMessage)
                    ->subject('Responsable Notification')
                    ->line("Votre action est requise pour le sinistre #{$this->data['num_sin']} {$this->data['status']}.");
            default:
                return (new MailMessage)
                    ->subject('Notification')
                    ->line('Bienvenue dans notre application.');
        }

        
    }
    
    public function toDatabase(object $notifiable): array
    {
        return [
            'user_type' => $this->userType,
            'data' => $this->data,
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
