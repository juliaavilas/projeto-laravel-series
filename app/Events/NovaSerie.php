<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

//criado só pra o email
class NovaSerie
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nomeSerie;
    public $qdtTemporadas;
    public $qdtEpisodios;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nomeSerie, $qdtTemporadas, $qdtEpisodios)
    {
        $this->nomeSerie = $nomeSerie;
        $this->qdtTemporadas = $qdtTemporadas;
        $this->qdtEpisodios = $qdtEpisodios;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
