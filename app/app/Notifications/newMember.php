<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\HtmlString;

class newMember extends Notification
{
    use Queueable;

    protected $user;
    protected $team;
    protected $newMember;

    /**
     * Create a new notification instance.
     */
    public function __construct($newMember, $team, $user)
    {
        $this->user = $user;
        $this->team = $team;
        $this->newMember = $newMember;

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

        return (new MailMessage)
                    ->from('PassManager@mail.com', 'PassManager')
                    ->line(new HtmlString('<strong>'.$this->newMember->name.'</strong> '. __('notif.beenadded') .' <strong>'.$this->team->name.'</strong> '. __('notif.by') .' <strong>'.$this->user->name.'</strong> '. __('notif.at') .' <strong>'. now() .'</strong>'))
                    ->line(__('notif.thanks'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "host_user" => $this->team->name,
            "team" => $this->team->name,
            "added_user" => $this->newMember->name,
            "date" => now()
        ];
    }
}
