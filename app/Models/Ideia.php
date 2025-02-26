<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ideia extends Model
{
    use HasFactory;

    protected $fillable = ['livro_id', 'titulo', 'descricao'];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
