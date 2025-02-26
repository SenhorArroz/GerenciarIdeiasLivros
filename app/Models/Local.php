<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $fillable = ['livro_id', 'nome', 'descricao', 'imagem'];
    protected $table = 'locais';

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
