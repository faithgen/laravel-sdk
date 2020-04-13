<?php

namespace FaithGen\SDK\Notifications\Ministry;

use FaithGen\SDK\Models\Ministry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountActivated extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var Ministry
     */
    private $ministry;

    /**
     * Create a new notification instance.
     *
     * @return void
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
        return (new MailMessage)
            ->greeting('Hello '.$this->ministry->name)
            ->subject('Account activated')
            ->line('Your FaithGen account has been activated.')
            ->line('Please feel free to use our platform and always contact support if you miss something.')
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
