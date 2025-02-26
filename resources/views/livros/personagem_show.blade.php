@extends('layouts.app')

@section('title', "Detalhes de {$personagem->nome}")

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg p-4 position-relative">
                <div class="row g-4 align-items-center">
                    <!-- Imagem do Personagem -->
                    <div class="col-md-5 text-center">
                        <img src="{{ $personagem->imagem ? asset($personagem->imagem) : asset('personagem.png') }}" 
                             class="img-fluid rounded" 
                             alt="Imagem de {{ $personagem->nome }}"
                             style="max-height: 400px; object-fit: cover;">
                    </div>

                    <!-- Informações do Personagem -->
                    <div class="col-md-7">
                        <h1 class="fw-bold text-primary">{{ $personagem->nome }}</h1>
                        <h4 class="text-muted">Idade: {{ $personagem->idade ?? 'Desconhecida' }}</h4>
                        <hr>
                        <div class="text-dark fs-5">
                            {!! $personagem->descricao !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botões de Ação Flutuantes -->
<a href="{{ route('livros.personagens', [$livro->slug, $livro->id]) }}" 
    class="btn btn-secondary d-flex align-items-center justify-content-center rounded-circle shadow-lg position-fixed bottom-0 start-0 m-4"
    style="width: 64px; height: 64px;">
     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M11 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H10.5A.5.5 0 0 1 11 8"/>
     </svg>
 </a>
<div class="position-fixed bottom-0 end-0 m-4 d-flex gap-2">
    <!-- Botão de Editar (abre modal) -->
    <button type="button" class="btn btn-warning btn-lg shadow-lg rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEditarPersonagem">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10A.5.5 0 0 1 5.5 14H2a.5.5 0 0 1-.5-.5v-3.5a.5.5 0 0 1 .146-.354l10-10zM11.207 3H10v1.207l1.207-1.207zM9 5V3H5v10h10V9h-1V5H9zm4 1V3.5L11.5 5H13z"/>
        </svg>
    </button>

    <!-- Botão de Deletar -->
    <form action="{{ route('personagens.destroy',  [$livro->slug, $livro->id, $personagem->nome, $personagem->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este personagem?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-lg shadow-lg rounded-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5v8h5v-8h-5zM7.5 2v1H10V2H7.5zM4.5 3H12l-.5 1H5l-.5-1z"/>
                <path d="M1 4h14v1H1V4zm3 1h8l.5 9h-9l.5-9z"/>
            </svg>
        </button>
    </form>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="modalEditarPersonagem" tabindex="-1" aria-labelledby="modalEditarPersonagemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarPersonagemLabel">Editar Personagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('personagens.update', [$livro->slug, $livro->id, $personagem->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ $personagem->nome }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="idade" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="idade" name="idade" value="{{ $personagem->idade }}">
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ $personagem->descricao }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="imagem" class="form-label">Imagem do Personagem</label>
                        <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<script>
    let editorInstance;

    function carregarEditor() {
        const descricao = document.querySelector('#descricao');

        if (descricao && !descricao.classList.contains('ck-loaded')) {
            ClassicEditor
                .create(descricao, {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'undo', 'redo'
                    ],
                    removePlugins: [
                        'CKFinder', 'EasyImage', 'ImageUpload',
                        'Image', 'ImageToolbar', 'ImageInsert', 
                        'Link', 'Table', 'MediaEmbed', 'BlockQuote'
                    ]
                })
                .then(editor => {
                    editorInstance = editor;
                    descricao.classList.add('ck-loaded');
                })
                .catch(error => {
                    console.error('Erro ao carregar o editor:', error);
                });
        }
    }

    document.addEventListener('DOMContentLoaded', carregarEditor);

    document.getElementById('modalEditarPersonagem').addEventListener('shown.bs.modal', () => {
        setTimeout(carregarEditor, 500);
    });

    document.getElementById('modalEditarPersonagem').addEventListener('hidden.bs.modal', () => {
        if (editorInstance) {
            editorInstance.destroy().then(() => {
                editorInstance = null;
                document.querySelector('#descricao').classList.remove('ck-loaded');
            });
        }
    });
</script>

@endsection
