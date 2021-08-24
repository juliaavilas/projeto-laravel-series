<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Models\Temporada;
use Illuminate\Support\Facades\Storage;

class Serie extends Model
{
    public $timestamps = false;
    protected $fillable = ['nome', 'capa']; //define quais atributos deverão ser passados dessa forma(formulario)
 
    public function getCapaUrlAttribute (){
        
        if($this->capa){
            return Storage::url($this->capa);
        }
        return Storage::url('serie/sem-imagem.jpg');
    }

    public function temporadas()
    {
        return $this->hasMany( related: Temporada::class);
    }
}