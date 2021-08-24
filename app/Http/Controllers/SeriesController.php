<?php

namespace App\Http\Controllers;

use App\Events\NovaSerie as EventsNovaSerie;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\NovaSerie;
use Illuminate\Http\Request;
use App\Serie;
use App\Models\Temporada;
use App\Models\Episodio;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    public function index (Request $request) {

       // $series = Serie::all();
        //var_dump($series);
        //exit();
        $series = serie::query()->orderBy(column: 'nome') ->get();
        $mensagem = $request->session()->get(key: 'mensagem');

        return view('series.index', compact('series', 'mensagem'));


    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {
        
        $request->validate([
            'nome' => 'required|min:3'
    
        ]);

    //     $nome = $request->nome;
    //     $serie = new Serie();
    //     $serie->nome = $nome;
    //     $serie->save();
    
        // Serie::create([
        //     'nome' => $nome
        // ]));

        // $serie = Serie::create($request->all());
        // $request->session()  //uso de flash para durar a mensagem apenas uma requisição
        // ->flash(
        //     'mensagem',
        //     "Série {$serie->id} criada com sucesso {$serie->nome}"
        //     );


        // $serie = Serie::create(['nome' => $request->nome]);
        // $qtdTemporadas = $request->qtd_temporadas;
        // for ($i = 1; $i <= $qtdTemporadas; $i++) {
        //     $temporada = $serie->temporadas()->create(['numero' => $i]);
    
        //     for ($j = 1; $j <= $request->ep_por_temporada; $j++) {
        //         $temporada->episodios()->create(['numero' => $j]);
        //     }
        // }

        $capa = null;
        if($request->hasFile('capa')){
            $capa = $request->file('capa')->store('public/serie');
        }
        $serie = $criadorDeSerie->criarSerie(
            $request->nome, 
            $request->qtd_temporadas, 
            $request->ep_por_temporada,
            $capa
        );

        //envio de email para um usuário 
        // $email = new NovaSerie(
        //     $request->nome, 
        //     $request->qtd_temporadas, 
        //     $request->ep_por_temporada
        // );
        // $email->subject = 'Nova Séria Adicionada';
        // $user = $request->user();
        //  Mail::to($user)->send($email);

        //enviando email para todos os usuarios
        // $users = User::all();
        // foreach ($users as $user) {
        //     $email = new NovaSerie(
        //         $request->nome, 
        //         $request->qtd_temporadas, 
        //         $request->ep_por_temporada
        //     );
        //     $email->subject = 'Nova Séria Adicionada';
        //    Mail::to($user)->send($email); //envio normal
        //     //Mail::to($user)->queue($email);//colocando email na fila, nunca usa assim
        //    // sleep(5); //a cada 5 seg manda outro email
        // }

        //envio de email com espera entre eles
        // $users = User::all();
        // foreach ($users as $indice => $user) {
        //     $multiplicador = $indice + 1;
        //     $email = new NovaSerie(
        //         $request->nome, 
        //         $request->qtd_temporadas, 
        //         $request->ep_por_temporada
        //     );
        //     $email->subject = 'Nova Séria Adicionada';
        //     $quando = now()->addSecond($multiplicador * 10);
        //     Mail::to($user)->later($quando, $email); 
        // }
        
        //envio de email usando evento
        $eventoNovaSerie = new EventsNovaSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );
        event($eventoNovaSerie);

        $request->session()
            ->flash(
                'mensagem',
                "Série: {$serie->nome} ; e suas temporadas e episódios criados com sucesso"
            );


        //echo "Série com id ($serie->id) criada: ($serie->nome)";
        return redirect('/series');


    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {

        $nomeSerie = $removedorDeSerie->removerSerie($request->id);

        $request->session()
            ->flash(
                'mensagem',
                "Série $nomeSerie removida com sucesso"
            );

        return redirect(to: '/series');
    }

    public function editaNome(int $id, Request $request)
    {
        $novoNome = $request->nome;
        $serie = Serie::find($id);
        $serie->nome = $novoNome;
        $serie->save();
    }

}
