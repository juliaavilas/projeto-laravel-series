<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovaSerie extends Mailable
{
    use Queueable, SerializesModels;
    
    public $nome;
    public $qdtTemporadas;
    public $qdtEpisodios;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $qdtTemporadas, $qdtEpisodios)
    {
        $this->nome = $nome;
        $this->qdtTemporadas = $qdtTemporadas;
        $this->qdtEpisodios = $qdtEpisodios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.serie.nova-serie');
    }
}
