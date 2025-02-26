@extends('layouts.app')

@section('title', "Locais de {$livro->nome}")

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Locais de {{ $livro->nome }}</h1>

    <div class="row">
        @forelse ($locais as $local)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="{{ $local->imagem ? asset($local->imagem) : asset('localizacao.png') }}" 
                     class="card-img-top" 
                     alt="Imagem do Local" 
                     style="max-height: 250px; width: 100%; object-fit: scale-down; background-color: #f8f9fa;">
                <div class="card-body">
                    <h5 class="card-title text-dark">{{ $local->nome }}</h5>
                    <p class="card-text text-dark">{!! $local->descricao !!}</p>

                    <!-- Botões dentro do card -->
                    <div class="d-flex justify-content-between">
                        <!-- Botão para abrir o modal de edição -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditarLocal{{ $local->id }}">
                            Editar
                        </button>

                        <!-- Botão de excluir -->
                        <form action="{{ route('locais.destroy', [$livro->id, $local->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este local?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
         <!-- Modal para edição -->
         <div class="modal fade" id="modalEditarLocal{{ $local->id }}" tabindex="-1" aria-labelledby="modalEditarLocalLabel{{ $local->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Local</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('locais.update', [$livro->id, $local->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{ $local->nome }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $local->descricao }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagem" class="form-label">Imagem do Local</label>
                                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
            Não há locais para esse livro.
        @endforelse
        
    </div>

    <!-- Botão flutuante para adicionar novo local -->
    <button type="button" class="btn btn-primary position-fixed bottom-0 end-0 m-4" data-bs-toggle="modal" data-bs-target="#modalCriarLocal">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
          </svg>
    </button>
</div>
<!-- Botão Flutuante para Voltar -->
<a href="{{ route('livros.dashboard', [$livro->slug, $livro->id]) }}" 
    class="btn btn-secondary d-flex align-items-center justify-content-center rounded-circle shadow-lg position-fixed bottom-0 start-0 m-4"
    style="width: 64px; height: 64px;">
     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M11 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H10.5A.5.5 0 0 1 11 8"/>
     </svg>
 </a>
 

<!-- Modal para criar novo local -->
<div class="modal fade" id="modalCriarLocal" tabindex="-1" aria-labelledby="modalCriarLocalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar Novo Local</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('locais.store', $livro->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagem" class="form-label">Imagem do Local</label>
                        <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
