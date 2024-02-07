<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\HtmlString;

class newPasswordTeam extends Notification
{
    use Queueable;

    protected $user;
    protected $team;
    protected $newPasswordUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $team, $newPasswordUrl)
    {
        $this->user = $user;
        $this->team = $team;
        $this->newPasswordUrl = $newPasswordUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->from('PassManager@mail.com', 'PassManager')
                    ->line(new HtmlString('A new password has been added to <strong>'.$this->team->name.'</strong> by <strong>'.$this->user->name.'</strong>  at <strong>'. now() .'</strong> for the website '.$this->newPasswordUrl))
                    ->line('Thank you for using our application!');
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
