<?php

namespace App\Notifications;

use App\Models\Verification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentNotification extends Notification
{
    use Queueable;
    public $verif;
    /**
     * Create a new notification instance.
     */
    public function __construct(Verification $v)
    {
        //
        $this->verif = $v;
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
                    ->subject('Document Confidentiel '.$this->verif->document->intitule.' [KeyceInformatique]')
                    ->greeting('Bonjour M./Mme '.$this->verif->nom_verif)
                    ->line('Ci-joint la version signé du document '.$this->verif->document->intitule.' au quel vous avez demandé accès')
                    ->line('Cordialement l\'équipe Keyce')
                    ->attach(storage_path('app'.DIRECTORY_SEPARATOR.str_replace('/',DIRECTORY_SEPARATOR,$this->verif->document->signedfile)),[
                        'as'=>$this->verif->document->intitule.'.pdf',
                        'mime'=>'application/pdf'
                    ]);
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
