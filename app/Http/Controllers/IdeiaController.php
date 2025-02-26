<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Ideia;
use Illuminate\Http\Request;

class IdeiaController extends Controller
{
    public function store(Request $request, Livro $livro)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        Ideia::create([
            'livro_id' => $livro->id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
        ]);

        return back()->with('success', 'Ideia criada com sucesso!');
    }

    public function update(Request $request, Livro $livro, Ideia $ideia)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        $ideia->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
        ]);

        return back()->with('success', 'Ideia atualizada com sucesso!');
    }

    public function destroy(Livro $livro, Ideia $ideia)
    {
        $ideia->delete();

        return redirect()->route('livros.ideias', [$livro->slug, $livro->id]);
    }
}
