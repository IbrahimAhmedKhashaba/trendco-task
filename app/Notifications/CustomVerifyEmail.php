<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verifyUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(__('msgs.mail_verify_title'))
            ->line(__('msgs.mail_verify_body'))
            ->action(__('msgs.mail_verify_title'), $verifyUrl)
            ->line(__('msgs.mail_not_you'));
    }
}
