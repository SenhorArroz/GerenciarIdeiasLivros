@extends('layouts.app')

@section('title', "Capítulo {$capitulo->numero} - {$capitulo->nome}")

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg p-4 position-relative">
                <div class="card-body">
                    <h1 class="fw-bold text-primary">Capítulo {{ $capitulo->numero }}: {{ $capitulo->nome }}</h1>
                    <hr>
                    <div class="text-dark fs-5">
                        {!! $capitulo->descricao !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botões Flutuantes -->
<a href="{{ route('livros.capitulos', [$livro->slug, $livro->id]) }}" 
    class="btn btn-secondary d-flex align-items-center justify-content-center rounded-circle shadow-lg position-fixed bottom-0 start-0 m-4"
    style="width: 64px; height: 64px;">
     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M11 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H10.5A.5.5 0 0 1 11 8"/>
     </svg>
 </a>
<div class="position-fixed bottom-0 end-0 m-4 d-flex flex-column gap-3">
    <!-- Botão de Editar -->
    <button class="btn btn-warning d-flex align-items-center justify-content-center rounded-circle shadow-lg" 
            style="width: 64px; height: 64px;" data-bs-toggle="modal" data-bs-target="#modalEditar">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10A.5.5 0 0 1 5.5 14H2a.5.5 0 0 1-.5-.5v-3.5a.5.5 0 0 1 .146-.354l10-10zM11.207 3H10v1.207l1.207-1.207zM9 5V3H5v10h10V9h-1V5H9zm4 1V3.5L11.5 5H13z"/>
        </svg>
    </button>

    <!-- Botão de Deletar -->
    <form action="{{ route('capitulos.destroy', [$livro->id, $capitulo->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este capítulo?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger d-flex align-items-center justify-content-center rounded-circle shadow-lg"
                style="width: 64px; height: 64px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5v8h5v-8h-5zM7.5 2v1H10V2H7.5zM4.5 3H12l-.5 1H5l-.5-1z"/>
                <path d="M1 4h14v1H1V4zm3 1h8l.5 9h-9l.5-9z"/>
            </svg>
        </button>
    </form>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Capítulo {{ $capitulo->numero }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('capitulos.update', [$livro->id, $capitulo->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Número</label>
                        <input type="number" class="form-control" name="numero" value="{{ $capitulo->numero }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" value="{{ $capitulo->nome }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control ckeditor" name="descricao" id="descricao">{{ $capitulo->descricao }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#descricao'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo']
        })
        .catch(error => {
            console.error('Erro ao carregar o editor:', error);
        });
</script>
@endsection
