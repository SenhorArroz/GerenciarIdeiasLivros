<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ilustracao;
use App\Models\Livro;
use Illuminate\Support\Facades\Storage;

class IlustracaoController extends Controller
{
    public function store(Request $request, Livro $livro)
    {
        $request->validate([
            'imagem' => 'required|image|max:2048',
            'descricao' => 'nullable|string',
        ]);

        $imagem = $request->file('imagem');
        $nomeArquivo = time() . '_' . $imagem->getClientOriginalName();
        $caminhoImagem = 'ilustracoes/' . $nomeArquivo;

        $imagem->move(public_path('storage/ilustracoes'), $nomeArquivo);

        Ilustracao::create([
            'livro_id' => $livro->id,
            'imagem' => $caminhoImagem,
            'descricao' => $request->descricao,
        ]);

        return back()->with('success', 'Ilustração adicionada com sucesso.');
    }

    public function update(Request $request, Livro $livro, Ilustracao $ilustracao)
    {
        $request->validate([
            'imagem' => 'nullable|image|max:2048',
            'descricao' => 'nullable|string',
        ]);

        if ($request->hasFile('imagem')) {
            if ($ilustracao->imagem && file_exists(public_path('storage/' . $ilustracao->imagem))) {
                unlink(public_path('storage/' . $ilustracao->imagem));
            }

            $imagem = $request->file('imagem');
            $nomeArquivo = time() . '_' . $imagem->getClientOriginalName();
            $caminhoImagem = 'ilustracoes/' . $nomeArquivo;

            $imagem->move(public_path('storage/ilustracoes'), $nomeArquivo);
            $ilustracao->imagem = $caminhoImagem;
        }

        $ilustracao->descricao = $request->descricao;
        $ilustracao->save();

        return back()->with('success', 'Ilustração atualizada com sucesso.');
    }

    public function destroy(Livro $livro, Ilustracao $ilustracao)
    {
        if ($ilustracao->imagem && file_exists(public_path('storage/' . $ilustracao->imagem))) {
            unlink(public_path('storage/' . $ilustracao->imagem));
        }

        $ilustracao->delete();

        return back()->with('success', 'Ilustração removida com sucesso.');
    }
}
