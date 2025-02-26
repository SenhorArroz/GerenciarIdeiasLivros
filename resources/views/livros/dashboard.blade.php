@extends('layouts.app')

@section('title', "Dashboard do Livro: $livro->nome")

@section('content')
<a href="{{ route('site.home') }}" 
    class="btn btn-secondary d-flex align-items-center justify-content-center rounded-circle shadow-lg position-fixed bottom-0 start-0 m-4"
    style="width: 64px; height: 64px;">
     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M11 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H10.5A.5.5 0 0 1 11 8"/>
     </svg>
 </a>
<div class="container mt-5">
    <h1 class="mb-4">Painel do Livro: {{ $livro->nome }}</h1>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center">
                <a href="{{ route('livros.personagens', ['nome' => $livro->slug, 'id' => $livro->id]) }}" class="text-decoration-none text-dark">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                            <path d="M13 7c0 1.104-.896 2-2 2s-2-.896-2-2 .896-2 2-2 2 .896 2 2zM7 7c0 1.104-.896 2-2 2S3 8.104 3 7s.896-2 2-2 2 .896 2 2z"/>
                            <path d="M0 13c0-1.104 2.686-2 6-2s6 .896 6 2v1H0v-1zM16 13c0-1.104-2.686-2-6-2s-6 .896-6 2v1h12v-1z"/>
                        </svg>
                        <h5 class="mt-2">Personagens</h5>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <a href="{{ route('livros.locais', ['nome' => $livro->slug, 'id' => $livro->id]) }}" class="text-decoration-none text-dark">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                            <path d="M8 0a5 5 0 0 0-5 5c0 3.25 5 10.5 5 10.5s5-7.25 5-10.5a5 5 0 0 0-5-5zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                        </svg>
                        <h5 class="mt-2">Locais</h5>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <a href="{{ route('livros.capitulos', ['nome' => $livro->slug, 'id' => $livro->id]) }}" class="text-decoration-none text-dark">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                            <path d="M1 2.75A2.75 2.75 0 0 1 3.75 0h9A2.75 2.75 0 0 1 15.5 2.75v10.5a2.75 2.75 0 0 1-2.75 2.75h-9A2.75 2.75 0 0 1 1 13.25V2.75z"/>
                        </svg>
                        <h5 class="mt-2">Capítulos</h5>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <a href="{{ route('livros.ideias', ['nome' => $livro->slug, 'id' => $livro->id]) }}" class="text-decoration-none text-dark">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-lightbulb" viewBox="0 0 16 16">
                            <path d="M2 6a6 6 0 1 1 12 0c0 2.9-2.686 5-6 5s-6-2.1-6-5z"/>
                        </svg>
                        <h5 class="mt-2">Ideias</h5>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <a href="{{ route('livros.anotacoes', ['nome' => $livro->slug, 'id' => $livro->id]) }}" class="text-decoration-none text-dark">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.792 9.792a.5.5 0 0 1-.168.11l-4 1a.5.5 0 0 1-.63-.63l1-4a.5.5 0 0 1 .11-.168l9.792-9.792z"/>
                        </svg>
                        <h5 class="mt-2">Anotações</h5>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <a href="{{ route('livros.ilustracoes', ['nome' => $livro->slug, 'id' => $livro->id]) }}" class="text-decoration-none text-dark">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                            <path d="M0 3a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H3a3 3 0 0 1-3-3V3z"/>
                        </svg>
                        <h5 class="mt-2">Ilustrações</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<button class="btn btn-secondary position-fixed top-0 end-0 m-4" data-bs-toggle="offcanvas" data-bs-target="#infoLivro">
    Informações do Livro
</button>

<div class="offcanvas offcanvas-end" tabindex="-1" id="infoLivro" aria-labelledby="infoLivroLabel">
    <div class="offcanvas-header">
        <h5 id="infoLivroLabel">Informações do Livro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('livros.update', ['nome' => $livro->slug, 'id' => $livro->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-3 text-center">
                <img src="{{ $livro->capa ? asset($livro->capa->image) : asset('image_livro.jpg') }}" class="img-fluid" style="max-height: 200px; object-fit: contain;">
                <input type="file" class="form-control mt-2" name="capa">
            </div>
            <div class="mb-3">
                <label class="form-label">Nome do Livro</label>
                <input type="text" class="form-control" name="nome" value="{{ $livro->nome }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Sinopse</label>
                <textarea class="form-control" name="sinopse" rows="4" required>{{ $livro->sinopse }}</textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">Atualizar</button>
        </form>
        <form action="{{ route('livros.delete', ['nome' => $livro->nome, 'id' => $livro->id]) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">Deletar Livro</button>
        </form>
    </div>
</div>
@endsection
