<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class CustomResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     */
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        // Include the email in the signed parameters so the signature is valid
        $resetUrl = URL::temporarySignedRoute(
            'password.reset',
            Carbon::now()->addMinutes(60),
            [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset() ?? $notifiable->email,
            ],
        );

        return (new MailMessage)
            ->subject('Atur Ulang Kata Sandi Anda')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. Klik tombol di bawah untuk membuat kata sandi baru:')
            ->action('Atur Ulang Kata Sandi', $resetUrl)
            ->line('Tautan ini hanya berlaku selama 60 menit. Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.')
            ->salutation('Salam Pers Mahasiswa!');
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
