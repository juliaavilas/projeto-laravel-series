<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Temporada;


class Episodio extends Model
{
    public $timestamps = false;
    protected $fillable = ['numero'];
    
    public function temporada()
    {
        return $this->belongsTo(Temporada::class);
    }
}
