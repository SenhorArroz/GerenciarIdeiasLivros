<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capa extends Model
{
    use HasFactory;

    protected $fillable = ['livro_id', 'image'];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
