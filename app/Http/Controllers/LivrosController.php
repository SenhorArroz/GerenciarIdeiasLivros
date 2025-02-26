<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivrosController extends Controller
{
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nome' => 'required|string|max:255',
            'sinopse' => 'required|string',
        ]);
        $livro = new Livro();
        $livro->nome = $validation['nome'];
        $livro->sinopse = $validation['sinopse'];
        $livro->slug = Str::slug($validation['nome']);
        $livro->save();
        return redirect()->back();
    }

    public function update(Request $request, string $nome, string $id)
    {
        $livro = Livro::findOrFail($id);
        $validation = $request->validate([
            'nome' => 'required|string|max:255',
            'sinopse' => 'required|string',
            'capa' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Atualiza os dados do livro
        $livro->nome = $validation['nome'];
        $livro->sinopse = $validation['sinopse'];
        $livro->slug = Str::slug($validation['nome']);
        $livro->save();
    
        // Verifica se há uma nova imagem de capa
        if ($request->hasFile('capa')) {
            $capa = $request->file('capa');
            $caminho = 'livros/capas/' . Str::slug($livro->nome);
            $nomeArquivo = time() . '.' . $capa->getClientOriginalExtension();
            $capa->move(public_path($caminho), $nomeArquivo);
    
            // Salva na tabela de capas
            if ($livro->capa) {
                // Deleta a capa anterior
                $caminhoAnterior = public_path($livro->capa->image);
                if (file_exists($caminhoAnterior)) {
                    unlink($caminhoAnterior);
                }
                $livro->capa()->update(['image' => $caminho . '/' . $nomeArquivo]);
            } else {
                $livro->capa()->create(['image' => $caminho . '/' . $nomeArquivo]);
            }
        }
    
        return redirect()->route('livros.dashboard', [$livro->slug, $livro->id]);
    }
    

    public function destroy(string $nome,string $id)
    {
        $livro = Livro::findOrFail($id);

        // Remove a capa se existir
        if ($livro->capa && file_exists(public_path($livro->capa))) {
            unlink(public_path($livro->capa));
        }

        // Remove o livro
        $livro->delete();

        return redirect()->route('site.home')->with('success', 'Livro deletado com sucesso!');
    }
}
