<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anotacao extends Model
{
    use HasFactory;

    protected $fillable = ['livro_id', 'titulo', 'descricao'];
    protected $table = 'anotacoes';

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
