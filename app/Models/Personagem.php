<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personagem extends Model
{
    use HasFactory;

    protected $fillable = ['livro_id', 'nome', 'idade', 'descricao', 'imagem'];
    protected $table = 'personagens';

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
