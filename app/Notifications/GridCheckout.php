<?php
/**
 * GridCheckout
 *
 * Notification to send email when a grid is validated
 *
 * Bastien Nicoud
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Evaluation;

class GridCheckout extends Notification
{
    use Queueable;

    protected $grid;

    /**
     * Create a new notification instance.
     *
     * @param Evaluation $grid
     * @return void
     */
    public function __construct(Evaluation $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Evaluation de stage validée !')
            ->greeting('Evaluation de stage validée !')
            ->line("L'évaluation de la visite du " . $this->grid->visit->moment->format('d-m-Y') . " viens d'être validée")
            ->line("Vous ne pouvez plus editer cette grille, pour la consulter :")
            ->action('Voir la grille', url('/evalgrid/grid/readonly/' . $this->grid->id))
            ->line('Ce mail est généré automatiquement, merci de ne pas répondre a ce mail.');
            //->attach('');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
