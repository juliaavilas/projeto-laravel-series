<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', 'SeriesController@index')->name('listar_series');
Route::get('/series', 'SeriesController@index')->name('listar_series');
Route::get('series/criar', 'SeriesController@create')->name('form_criar_serie')->middleware('auth');
Route::post('series/criar', 'SeriesController@store')->middleware('auth');
Route::delete('/series/{id}', 'SeriesController@destroy')->middleware('auth');
Route::post('series/{id}/editaNome', 'SeriesController@editaNome')->middleware('auth');

Route::get('series/{serieid}/temporadas', 'TemporadasController@index');
Route::get('temporadas/{temporada}/episodios', 'EpisodiosController@index');
Route::post('temporadas/{temporada}/episodios/assistir', 'EpisodiosController@assistir')->middleware('auth');

Route::get('entrar', 'EntrarController@index');
Route::post('entrar', 'EntrarController@entrar');

Route::get('registrar', 'RegistroController@create');
Route::post('registrar', 'RegistroController@store');

Route::get('/sair', function () {

    Auth::logout();
    return redirect('/entrar');
});

Route::get('/visualizando-email', function(){
    return new \App\Mail\NovaSerie(
        'Arrow', 5, 10
    );
} );

Route::get('/enviando-email', function(){
    $email = new \App\Mail\NovaSerie(
        'Arrow', 5, 10
    );

    $user = (object)[
        'email' => 'julia@teste.com',
        'name' => 'Júlia'
    ];
    $email->subject = 'Nova Séria Adicionada';
    Mail::to($user)->send($email);
    return('Email enviado');

} );
