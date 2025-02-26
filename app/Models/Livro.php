<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'sinopse'];

    public function personagens()
    {
        return $this->hasMany(Personagem::class);
    }

    public function locais()
    {
        return $this->hasMany(Local::class);
    }

    public function capa()
    {
        return $this->hasOne(Capa::class);
    }

    public function capitulos()
    {
        return $this->hasMany(Capitulo::class);
    }

    public function ideias()
    {
        return $this->hasMany(Ideia::class);
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class);
    }

    public function ilustracoes()
    {
        return $this->hasMany(Ilustracao::class);
    }
}
