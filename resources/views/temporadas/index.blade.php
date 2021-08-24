@extends('layout')

@section('cabecalho')
    Temporadas de {{ $serie->nome }}
@endsection

@section('conteudo')

@if($serie->capa)
<div class="row mb5">
    <div class="col-md-12 text-center">
        <img src="{{ $serie->capa_url }}" class="img-thumbnail" height="300px" width="300px">
    </div>
</div>
@endif

<a href="/" class="btn btn-dark mb-2">Séries</a>

    <ul class="list-group">
        @foreach($temporadas as $temporada)
            <li class="list-group-item d-flex justify-content-between align-items-center">
               <a href="/temporadas/{{ $temporada->id }}/episodios"> Temporada {{ $temporada->numero }}</a>
            
                <span class="badge badge-secondary">
                    {{ $temporada->getEpisodiosAssistidos()->count() }}/ {{ $temporada->episodios->count() }}
                </span>
            </li>
        @endforeach
    </ul>
@endsection

