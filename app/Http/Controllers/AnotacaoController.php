<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anotacao;
use App\Models\Livro;

class AnotacaoController extends Controller
{
    /**
     * Armazena uma nova anotação.
     */
    public function store(Request $request, Livro $livro)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $anotacao = new Anotacao();
        $anotacao->livro_id = $livro->id;
        $anotacao->titulo = $request->titulo;
        $anotacao->descricao = $request->descricao;
        $anotacao->save();

        return redirect()->back()->with('success', 'Anotação criada com sucesso!');
    }

    /**
     * Atualiza uma anotação existente.
     */
    public function update(Request $request, Livro $livro, Anotacao $anotacao)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $anotacao->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
        ]);

        return redirect()->back()->with('success', 'Anotação atualizada com sucesso!');
    }

    /**
     * Remove uma anotação.
     */
    public function destroy(Livro $livro, Anotacao $anotacao)
    {
        $anotacao->delete();

        return redirect()->back()->with('success', 'Anotação removida com sucesso!');
    }
}
