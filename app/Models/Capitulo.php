<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{
    use HasFactory;

    protected $fillable = ['livro_id', 'numero', 'nome', 'descricao'];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function ilustracoes()
    {
        return $this->hasMany(Ilustracao::class);
    }
}
