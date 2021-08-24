<?php

namespace App\Services;

use App\Events\SerieApagada;
use App\Serie;
use App\Models\Temporada;
use App\Models\Episodio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RemovedorDeSerie
{
    public function removerSerie(int $serieId): string
    {
        $nomeSerie = '';
        DB::transaction( function () use ($serieId, &$nomeSerie){

            $serie = Serie::find($serieId);
            $nomeSerie = $serie->nome;


            $this->removerTemporadas($serie);
            $serie->delete();
            $evento = new SerieApagada($serie);
            event($evento);

        });

        return $nomeSerie;

    }

    private function removerTemporadas(Serie $serie): void
    {
        $serie->temporadas->each(function (Temporada $temporada) {

           $this->removerEpisodios($temporada);
           $temporada->delete();

        });


    }

    private function removerEpisodios(Temporada $temporada): void
    {
        $temporada->episodios()->each(function (Episodio $episodio) {
            $episodio->delete();
        });

    }
}