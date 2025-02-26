@extends('layouts.app')

@section('title', $ideia->titulo)

@section('content')
<a href="{{ route('livros.ideias', [$livro->slug, $livro->id]) }}" 
    class="btn btn-secondary d-flex align-items-center justify-content-center rounded-circle shadow-lg position-fixed bottom-0 start-0 m-4"
    style="width: 64px; height: 64px;">
     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M11 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H10.5A.5.5 0 0 1 11 8"/>
     </svg>
 </a>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h1 class="fw-bold text-primary">{{ $ideia->titulo }}</h1>
                    <p class="text-muted">Criado em {{ $ideia->created_at->format('d/m/Y H:i') }}</p>
                    <hr>
                    <div class="text-dark fs-5">
                        {!! $ideia->descricao !!}
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>
<div class="position-fixed bottom-0 end-0 m-4 d-flex gap-2">
    <!-- Botão de Editar (abre modal) -->
    <button type="button" class="btn btn-warning btn-lg shadow-lg rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEditarIdeia">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10A.5.5 0 0 1 5.5 14H2a.5.5 0 0 1-.5-.5v-3.5a.5.5 0 0 1 .146-.354l10-10zM11.207 3H10v1.207l1.207-1.207zM9 5V3H5v10h10V9h-1V5H9zm4 1V3.5L11.5 5H13z"/>
        </svg>
    </button>

    <!-- Botão de Deletar -->
    <form action="{{ route('ideias.destroy', [$livro->id, $ideia->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta ideia?');">
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
<div class="modal fade" id="modalEditarIdeia" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Ideia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ideias.update', [$livro->id, $ideia->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" value="{{ $ideia->titulo }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao" id="descricao">{!! $ideia->descricao !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
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

    document.getElementById('modalEditarIdeia').addEventListener('shown.bs.modal', () => {
        setTimeout(carregarEditor, 500);
    });

    document.getElementById('modalEditarIdeia').addEventListener('hidden.bs.modal', () => {
        if (editorInstance) {
            editorInstance.destroy().then(() => {
                editorInstance = null;
                document.querySelector('#descricao').classList.remove('ck-loaded');
            });
        }
    });
</script>
@endsection
