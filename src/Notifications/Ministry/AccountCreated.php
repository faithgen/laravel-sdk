<?php

namespace FaithGen\SDK\Notifications\Ministry;

use FaithGen\SDK\Models\Ministry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountCreated extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var Ministry
     */
    private $ministry;

    /**
     * Create a new notification instance.
     *
     * @param Ministry $ministry
     */
    public function __construct(Ministry $ministry)
    {
        //
        $this->ministry = $ministry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/auth/activate/'.$this->ministry->id.'/'.$this->ministry->activation->code);

        return (new MailMessage)
            ->greeting('Hello '.$this->ministry->name)
            ->subject('FaithGen account created!')
            ->from('accounts@faitghen.com', 'Faith Gen')
            ->line('We have received your account registration request, please just activate your account to get started with us')
            ->action('Activate account', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
