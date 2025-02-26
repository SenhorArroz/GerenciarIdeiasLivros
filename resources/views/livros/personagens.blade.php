@extends('layouts.app')

@section('title', "Personagens de {$livro->nome}")

@section('content')
<div class="container text-center mt-5">
    <h1 class="mb-4">Personagens de {{ $livro->nome }}</h1>

    <div class="row">
        @foreach($personagens as $personagem)
        <div class="col-md-4 mb-4">
            <a href="{{ route('personagens.show', [$livro->slug, $livro->id, $personagem->nome, $personagem->id]) }}" class="text-decoration-none">
                <div class="card shadow-sm">
                    <img src="{{ $personagem->imagem ? asset($personagem->imagem) : asset('personagem.png') }}" 
                    class="card-img-top" 
                    alt="Imagem do Personagem" 
                    style="max-height: 250px; width: 100%; object-fit: scale-down; background-color: #f8f9fa;">
               
                    <div class="card-body">
                        <h5 class="card-title text-dark">{{ $personagem->nome }}</h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <!-- Botão para adicionar novo personagem -->
    <button type="button" class="btn btn-primary position-fixed bottom-0 end-0 m-4" id="abrirModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
            <path d="M6 8c1.654 0 3-1.346 3-3S7.654 2 6 2 3 3.346 3 5s1.346 3 3 3zM0 13c0-2.481 3.589-4 6-4s6 1.519 6 4v1H0v-1zM13 5h-1V4a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0V7h-1a1 1 0 1 1 0-2h1V4a1 1 0 1 1 2 0v1z"/>
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
 

<!-- Modal para criar novo personagem -->
<div class="modal fade" id="modalCriarPersonagem" tabindex="-1" aria-labelledby="modalCriarPersonagemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formPersonagem" action="{{ route('personagens.store', [$livro->slug, $livro->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCriarPersonagemLabel">Criar Novo Personagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="idade" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="idade" name="idade">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagem" class="form-label">Imagem do Personagem</label>
                        <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="salvarPersonagem">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Inclusão do Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                        'CKFinder', 'EasyImage', 'ImageUpload', // Remove plugins de imagem
                        'Image', 'ImageToolbar', 'ImageInsert', 
                        'Link', 'Table', 'MediaEmbed', 'BlockQuote'
                    ]
                })
                .then(editor => {
                    editorInstance = editor;
                    descricao.classList.add('ck-loaded'); // Evita recriação
                    console.log('Editor carregado com sucesso!');
                })
                .catch(error => {
                    console.error('Erro ao carregar o editor:', error);
                });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        carregarEditor();

        document.getElementById('abrirModal').addEventListener('click', function() {
            let modal = new bootstrap.Modal(document.getElementById('modalCriarPersonagem'));
            modal.show();
        });

        document.getElementById('salvarPersonagem').addEventListener('click', function() {
            let botao = this;
            let formulario = document.getElementById('formPersonagem');

            // Desativa o botão para evitar múltiplos envios
            botao.disabled = true;
            botao.textContent = 'Enviando...';

            if (editorInstance) {
                document.querySelector('#descricao').value = editorInstance.getData();
            }

            // Submete o formulário
            formulario.submit();
        });

        // Reativa o botão caso o modal seja fechado antes do envio
        document.getElementById('modalCriarPersonagem').addEventListener('hidden.bs.modal', () => {
            let botao = document.getElementById('salvarPersonagem');
            botao.disabled = false;
            botao.textContent = 'Salvar';
        });
    });
</script>

@endsection
