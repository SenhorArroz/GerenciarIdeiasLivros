@extends('layouts.app')

@section('title', 'Ideias')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Botão Flutuante para Voltar -->
<a href="{{ route('livros.dashboard', [$livro->slug, $livro->id]) }}" 
    class="btn btn-secondary d-flex align-items-center justify-content-center rounded-circle shadow-lg position-fixed bottom-0 start-0 m-4"
    style="width: 64px; height: 64px;">
     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M11 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H10.5A.5.5 0 0 1 11 8"/>
     </svg>
 </a>
 
            <h1 class="fw-bold text-primary mb-4">Ideias</h1>
            <div class="row">
                @foreach($ideias as $ideia)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title text-dark fw-bold">{{ $ideia->titulo }}</h5>
                                <a href="{{ route('ideias.show', [$livro->slug, $livro->id, $ideia->id]) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Botão Flutuante -->
<button class="btn btn-primary d-flex align-items-center justify-content-center rounded-circle shadow-lg position-fixed bottom-0 end-0 m-4"
   style="width: 64px; height: 64px;" data-bs-toggle="modal" data-bs-target="#modalCriarIdeia">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
        <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>

<!-- Modal de Criação -->
<div class="modal fade" id="modalCriarIdeia" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Ideia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ideias.create', $livro->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao" id="descricao"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Ideia</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CKEditor -->
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

    document.getElementById('modalCriarIdeia').addEventListener('shown.bs.modal', () => {
        setTimeout(carregarEditor, 500);
    });

    document.getElementById('modalCriarIdeia').addEventListener('hidden.bs.modal', () => {
        if (editorInstance) {
            editorInstance.destroy().then(() => {
                editorInstance = null;
                document.querySelector('#descricao').classList.remove('ck-loaded');
            });
        }
    });
</script>
@endsection
