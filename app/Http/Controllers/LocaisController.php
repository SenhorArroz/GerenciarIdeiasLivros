<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocaisController extends Controller
{
    public function store(Request $request, $id)
    {
        $livro = Livro::find($id);
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $caminho = null;
        if ($request->hasFile('imagem')) {
            $caminho = 'locais/imagens/' . time() . '.' . $request->imagem->getClientOriginalExtension();
            $request->imagem->move(public_path('locais/imagens'), $caminho);
        }

        $livro->locais()->create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'imagem' => $caminho,
        ]);

        return back()->with('success', 'Local criado com sucesso!');
    }

    public function update(Request $request, Livro $livro, Local $local)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'required|string',
        'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Verifica se o usuário enviou uma nova imagem
    if ($request->hasFile('imagem')) {
        // Deleta a imagem antiga, se existir
        if (!empty($local->imagem) && $local->imagem !== 'localizacao.png' && Storage::disk('public')->exists($local->imagem)) {
            Storage::disk('public')->delete($local->imagem);
        }

        // Salva a nova imagem
        $caminho = 'locais/imagens/' . time() . '.' . $request->imagem->getClientOriginalExtension();
        $request->imagem->move(public_path('locais/imagens'), $caminho);
    } else {
        // Mantém a imagem atual
        $caminho = $local->imagem;
    }

    // Atualiza os dados do local
    $local->update([
        'nome' => $request->nome,
        'descricao' => $request->descricao,
        'imagem' => $caminho, // Mantém a imagem antiga se nenhuma nova for enviada
    ]);

    return back()->with('success', 'Local atualizado com sucesso!');
}


    public function destroy(Livro $livro, Local $local)
    {
        if (!empty($local->imagem) && Storage::disk('public')->exists($local->imagem)) {
            Storage::disk('public')->delete($local->imagem);
        }

        $local->delete();
        return back()->with('success', 'Local excluído com sucesso!');
    }
}
