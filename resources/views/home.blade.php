@extends('layouts/app')

@section('title', 'Lista de Livros')

@section('content')
<div class="container text-center mt-5">
    <h1 class="mb-4">Lista de Livros</h1>
    <div class="row">
        @foreach($livros as $livro)
        <div class="col-md-4 mb-4">
            <a href="{{ route('livros.dashboard', [$livro->slug, $livro->id]) }}" class="text-decoration-none">
                <div class="card">
                    <img src="{{ $livro->capa ? asset($livro->capa->image) : asset('image_livro.jpg') }}" class="card-img-top" alt="Capa do Livro" style="max-height: 300px; object-fit: contain;">
                    <div class="card-body">
                        <h5 class="card-title text-dark">{{ $livro->nome }}</h5>
                        <p class="card-text text-dark">{{ $livro->sinopse }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<button type="button" class="btn btn-primary position-fixed bottom-0 end-0 m-4" data-bs-toggle="modal" data-bs-target="#modalCriarLivro">
    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5"/>
        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
    </svg>
</button>

<div class="modal fade" id="modalCriarLivro" tabindex="-1" aria-labelledby="modalCriarLivroLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCriarLivroLabel">Criar Novo Livro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('livros.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="sinopse" class="form-label">Sinopse</label>
                        <textarea class="form-control" id="sinopse" name="sinopse" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
