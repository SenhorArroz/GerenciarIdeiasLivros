<?php

namespace App\Http\Controllers;

use App\Models\Personagem;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersonagensController extends Controller
{
    public function index(string $nome, string $id)
    {
        $livro = Livro::with('personagens')->findOrFail($id);
        $personagens = $livro->personagens;

        return view('livros.personagens', compact('personagens', 'livro'));
    }


    public function store(Request $request, $slug, $livroId)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'idade' => 'nullable|integer|min:0',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $personagem = new Personagem();
        $personagem->nome = $request->nome;
        $personagem->idade = $request->idade;
        $personagem->descricao = $request->descricao;

        if ($request->hasFile('imagem')) {
            $caminho = $request->file('imagem')->store('personagens', 'public');
            $personagem->imagem = $caminho;
        }

        $personagem->livro_id = $livroId;
        $personagem->save();

        return redirect()->back()->with('success', 'Personagem criado com sucesso!');
    }


    public function update(Request $request, $slug, $livroId, $id)
    {
        $personagem = Personagem::findOrFail($id);
        $request->validate([
            'nome' => 'required|string|max:255',
            'idade' => 'nullable|integer',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,jpg,png,jpg,gif',
        ]);
        $personagem->nome = $request->nome;
        $personagem->idade = $request->idade;
        $personagem->descricao = $request->descricao;
        if ($request->hasFile('imagem')) {
            // Verifica se o personagem já tem uma imagem armazenada
            if (!empty($personagem->imagem) && Storage::exists($personagem->imagem)) {
                Storage::delete($personagem->imagem);
            }
        
            // Salva a nova imagem
            $caminho = 'personagens/imagens/' . time() . '.' . $request->imagem->getClientOriginalExtension();
            $request->imagem->move(public_path('personagens/imagens'), $caminho);
            
            // Atualiza o caminho da imagem no banco de dados
            $personagem->imagem = $caminho;
        }

        $personagem->save();
        return redirect()->route('personagens.show', [$personagem->livro->slug, $personagem->livro->id, $personagem->nome, $personagem->id]);
    }

    public function destroy($slug, $id, $pers, $perid)
    {
        $personagem = Personagem::findOrFail($perid);
        if ($personagem->imagem) {
            Storage::delete($personagem->imagem);
        }
        $livro = $personagem->livro;
        $personagem->delete();
        return redirect()->route('livros.personagens', [$livro->slug, $livro->id]);
    }
}
