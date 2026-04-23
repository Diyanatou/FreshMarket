<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderConfirmedNotification extends Notification
{
    use Queueable;

    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'commande_id' => $this->commande->id,
            'message' => "Votre commande #{$this->commande->id} a été enregistrée avec succès !",
            'total' => $this->commande->prix_total,
            'url' => route('checkout.success', $this->commande->id),
        ];
    }
}
