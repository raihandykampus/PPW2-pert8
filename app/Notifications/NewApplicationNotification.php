<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    use Queueable;
    public $application;

    /**
     * Create a new notification instance.
     */
    public function __construct($application)
    {
        $this->application = $application;
    }
        
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        // Tambahkan 'database' ke dalam array
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ada Lamaran Baru Masuk!')
            ->line('Ada pelamar baru untuk posisi: ' . $this->application->job->title)
            ->line('Nama Pelamar: ' . $this->application->user->name)
            ->action('Lihat Lamaran', url('/jobs/' . $this->application->job_id . '/applicants'));
    }
        
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Pelamar baru: ' . $this->application->user->name,
            'job_title' => $this->application->job->title,
            'application_id' => $this->application->id,
            'link' => url('/jobs/' . $this->application->job_id . '/applicants')
        ];
    }
}
