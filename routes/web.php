<?php

use App\Http\Controllers\AnotacaoController;
use App\Http\Controllers\CapituloController;
use App\Http\Controllers\IdeiaController;
use App\Http\Controllers\IlustracaoController;
use App\Http\Controllers\LivrosController;
use App\Http\Controllers\LocaisController;
use App\Http\Controllers\PersonagensController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/debug', function () {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        return 'DB OK, APP OK, TUDO OK';
    } catch (\Exception $e) {
        return 'ERRO DE DB: ' . $e->getMessage();
    }
});

Route::get('/', [SiteController::class, 'home'])->name('site.home');

Route::post('/addLivro', [LivrosController::class, 'store'])->name('livros.store');
Route::get('/{nome}/{id}/dashboard', [SiteController::class, 'livrosDashboard'])->name('livros.dashboard');
Route::get('/{nome}/{id}/locais', [SiteController::class, 'locais'])->name('livros.locais');
Route::get('/{nome}/{id}/capitulos', [SiteController::class, 'capitulos'])->name('livros.capitulos');
Route::get('/{nome}/{id}/ideias', [SiteController::class, 'ideias'])->name('livros.ideias');
Route::get('/{nome}/{id}/personagens', [PersonagensController::class, 'index'])->name('livros.personagens');
Route::get('/{nome}/{id}/anotacoes', [SiteController::class, 'anotacoes'])->name('livros.anotacoes');
Route::get('/{nome}/{id}/ilustracoes', [SiteController::class, 'ilustracoes'])->name('livros.ilustracoes');
Route::patch('/{nome}/{id}/update', [LivrosController::class, 'update'])->name('livros.update');
Route::delete('/{nome}/{id}/delete', [LivrosController::class, 'destroy'])->name('livros.delete');

Route::post('/{nome}/{id}/personagens', [PersonagensController::class, 'store'])->name('personagens.store');
Route::get('/{nome}/{id}/personagens/{personagem}/{perid}', [SiteController::class, 'showPersonagem'])->name('personagens.show');
Route::put('/{nome}/{id}/personagens/{personagem}', [PersonagensController::class, 'update'])->name('personagens.update');
Route::delete('/{nome}/{id}/personagens/{personagem}/{perid}', [PersonagensController::class, 'destroy'])->name('personagens.destroy');

Route::post('/livros/{livro}/locais', [LocaisController::class, 'store'])->name('locais.store');
Route::put('/livros/{livro}/locais/{local}', [LocaisController::class, 'update'])->name('locais.update');
Route::delete('/livros/{livro}/locais/{local}', [LocaisController::class, 'destroy'])->name('locais.destroy');

Route::post('/livros/{livro}/capitulos', [CapituloController::class, 'store'])->name('capitulos.store');
Route::put('/livros/{livro}/capitulos/{capitulo}', [CapituloController::class, 'update'])->name('capitulos.update');
Route::delete('/livros/{livro}/capitulos/{capitulo}', [CapituloController::class, 'destroy'])->name('capitulos.destroy');
Route::get('/livros/{livro}/{livroid}/capitulos/{capituloid}', [SiteController::class, 'capituloShow'])->name('capitulos.show');

Route::post('/ideias/{livro}', [IdeiaController::class, 'store'])->name('ideias.create');
Route::put('/ideias/{livro}/{ideia}', [IdeiaController::class, 'update'])->name('ideias.update');
Route::delete('/ideias/{livro}/{ideia}', [IdeiaController::class, 'destroy'])->name('ideias.destroy');
Route::get('/livros/{livro}/{livroid}/ideias/{ideiaid}', [SiteController::class, 'ideiaShow'])->name('ideias.show');

Route::post('/livros/{livro}/anotacoes', [AnotacaoController::class, 'store'])->name('anotacoes.create');
Route::put('/livros/{livro}/anotacoes/{anotacao}', [AnotacaoController::class, 'update'])->name('anotacoes.update');
Route::delete('/livros/{livro}/anotacoes/{anotacao}', [AnotacaoController::class, 'destroy'])->name('anotacoes.destroy');
Route::get('/livros/{livro}/{livroid}/anotacoes/{anotacaoid}', [SiteController::class, 'anotacoeShow'])->name('anotacoes.show');

Route::post('livros/{livro}/ilustracoes', [IlustracaoController::class, 'store'])->name('ilustracoes.store');
Route::put('livros/{livro}/ilustracoes/{ilustracao}', [IlustracaoController::class, 'update'])->name('ilustracoes.update');
Route::delete('livros/{livro}/ilustracoes/{ilustracao}', [IlustracaoController::class, 'destroy'])->name('ilustracoes.destroy');
