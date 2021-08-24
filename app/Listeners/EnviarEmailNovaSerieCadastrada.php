<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Mail\NovaSerie;
use Illuminate\Support\Facades\Mail;
use App\Events\NovaSerie as EventsNovaSerie;


class EnviarEmailNovaSerieCadastrada implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NovaSerie  $event
     * @return void
     */
    public function handle(EventsNovaSerie $event)
    {
        $nomeSerie = $event->nomeSerie;
        $qdtTemporadas = $event->qdtTemporadas;
        $qdtEpisodios = $event->qdtEpisodios;
        $users = User::all();
        foreach ($users as $indice => $user) {
            $multiplicador = $indice + 1;
            $email = new NovaSerie(
                $nomeSerie, 
                $qdtTemporadas, 
                $qdtEpisodios
            );
            $email->subject = 'Nova Séria Adicionada';
            $quando = now()->addSecond($multiplicador * 10);
            Mail::to($user)->later($quando, $email); 
        }
        
    }
}
