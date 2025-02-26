<?php

namespace App\Http\Controllers;

use App\Models\Anotacao;
use App\Models\Capitulo;
use App\Models\Ideia;
use App\Models\Livro;
use App\Models\Personagem;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        $livros = Livro::all();
        return view('home', compact('livros'));
    }
    public function livrosDashboard($slug, $id)
    {
        $livro = Livro::find($id);
        return view('livros/dashboard', compact('livro'));
    }
    public function showPersonagem($slug, $id, $pers, $perid)
    {
        $livro = Livro::find($id);
        $personagem = Personagem::find($perid);
        return view('livros/personagem_show', compact('personagem', 'livro'));
    }
    public function locais($slug, $id)
    {
        $livro = Livro::find($id);
        $locais = $livro->locais;
        return view('livros/locais', compact('locais', 'livro'));
    }
    public function capitulos($slug, $id)
    {
        $livro = Livro::find($id);
        $capitulos = $livro->capitulos;
        return view('livros/capitulos', compact('capitulos', 'livro'));
    }
    public function capituloShow($slug,$livroid, $id)
    {
        $livro = Livro::find($livroid);
        $capitulo = Capitulo::find($id);
        return view('livros/capitulos_show', compact('capitulo', 'livro'));
    }
    public function ideias($slug, $id)
    {
        $livro = Livro::find($id);
        $ideias = $livro->ideias;
        return view('livros/ideias', compact('ideias', 'livro'));
    }
    public function ideiaShow($slug,$livroid, $id)
    {
        $livro = Livro::find($livroid);
        $ideia = Ideia::find($id);
        return view('livros/ideias_show', compact('ideia', 'livro'));
    }
    public function anotacoes($slug, $id)
    {
        $livro = Livro::find($id);
        $anotacoes = $livro->anotacoes;
        return view('livros/anotacoes', compact('anotacoes', 'livro'));
    }
    public function anotacoeShow($slug,$livroid, $id)
    {
        $livro = Livro::find($livroid);
        $anotacao = Anotacao::find($id);
        return view('livros/anotacoes_show', compact('anotacao', 'livro'));
    }
    public function ilustracoes($slug, $id)
    {
        $livro = Livro::find($id);
        $ilustracoes = $livro->ilustracoes;
        return view('livros/ilustracoes', compact('ilustracoes', 'livro'));
    }
}
