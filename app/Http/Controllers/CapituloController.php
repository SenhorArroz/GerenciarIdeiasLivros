<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Capitulo;
use App\Models\Livro;

class CapituloController extends Controller
{
    public function store(Request $request, Livro $livro)
    {
        $request->validate([
            'numero' => 'required|integer',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        $livro->capitulos()->create([
            'numero' => $request->numero,
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return back()->with('success', 'Capítulo criado com sucesso!');
    }

    public function update(Request $request, Livro $livro, Capitulo $capitulo)
    {
        $request->validate([
            'numero' => 'required|integer',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        $capitulo->update([
            'numero' => $request->numero,
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return back()->with('success', 'Capítulo atualizado com sucesso!');
    }

    public function destroy(Livro $livro, Capitulo $capitulo)
    {
        $capitulo->delete();
        return redirect()->route('livros.capitulos', [$livro->slug, $livro->id]);
    }
}
