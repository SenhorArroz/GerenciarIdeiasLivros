<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ilustracao extends Model
{
    use HasFactory;

    protected $fillable = ['livro_id', 'imagem', 'descricao'];
    protected $table = 'ilustracoes';

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class);
    }
}
