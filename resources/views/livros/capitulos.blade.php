@extends('layouts.app')

@section('title', 'Capítulos de ' . $livro->nome)

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center text-primary fw-bold">Capítulos de {{ $livro->nome }}</h1>
            
            <!-- Lista de Capítulos -->
            <div class="list-group mt-4">
                @foreach ($capitulos as $capitulo)
                    <a href="{{ route('capitulos.show', [$livro->nome,$livro->id, $capitulo->id]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Capítulo {{ $capitulo->numero }}: {{ $capitulo->nome }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Botão Flutuante para Voltar -->
<a href="{{ route('livros.dashboard', [$livro->slug, $livro->id]) }}" 
    class="btn btn-secondary d-flex align-items-center justify-content-center rounded-circle shadow-lg position-fixed bottom-0 start-0 m-4"
    style="width: 64px; height: 64px;">
     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M11 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H10.5A.5.5 0 0 1 11 8"/>
     </svg>
 </a>
 

<!-- Botão Flutuante para Criar Capítulo -->
<button class="btn btn-primary position-fixed bottom-0 end-0 m-4 p-3 rounded-circle shadow-lg"
        data-bs-toggle="modal" data-bs-target="#modalCriarCapitulo">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5z"/>
          </svg>
</button>

<!-- Modal de Criação -->
<div class="modal fade" id="modalCriarCapitulo" tabindex="-1" aria-labelledby="modalCriarCapituloLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('capitulos.store', $livro->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCriarCapituloLabel">Criar Novo Capítulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="numero" class="form-label">Número</label>
                        <input type="number" name="numero" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
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