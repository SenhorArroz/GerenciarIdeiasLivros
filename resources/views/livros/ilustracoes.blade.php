@extends('layouts.app')

@section('title', 'Ilustrações')

@section('content')

<a href="{{ route('livros.dashboard', [$livro->slug,$livro->id]) }}" 
    class="btn btn-secondary d-flex align-items-center justify-content-center rounded-circle shadow-lg position-fixed bottom-0 start-0 m-4"
    style="width: 64px; height: 64px;">
     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M11 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H10.5A.5.5 0 0 1 11 8"/>
     </svg>
</a>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold text-primary">Ilustrações do Livro</h1>
            <hr>
            
            <div class="row g-4">
                @foreach ($ilustracoes as $ilustracao)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-lg">
                            <img src="{{ asset('storage/' . $ilustracao->imagem) }}" 
                                 class="card-img-top img-thumbnail ilustracao-click" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#modalExibirIlustracao" 
                                 data-src="{{ asset('storage/' . $ilustracao->imagem) }}" 
                                 alt="Ilustração">
                            <div class="card-body text-center">
                                <p class="text-muted">{{ $ilustracao->descricao ?? 'Sem descrição' }}</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Botão Atualizar -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarIlustracao-{{ $ilustracao->id }}">
                                        Editar
                                    </button>

                                    <!-- Botão Remover -->
                                    <form action="{{ route('ilustracoes.destroy', [$livro->id, $ilustracao->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover esta ilustração?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Editar Ilustração -->
                    <div class="modal fade" id="modalEditarIlustracao-{{ $ilustracao->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Ilustração</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('ilustracoes.update', [$livro->id, $ilustracao->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Nova Imagem (opcional)</label>
                                            <input type="file" class="form-control" name="imagem">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Descrição</label>
                                            <textarea class="form-control" name="descricao">{{ $ilustracao->descricao }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Botão flutuante para adicionar ilustrações -->
<button type="button" class="btn btn-primary btn-lg rounded-circle shadow-lg position-fixed bottom-0 end-0 m-4" 
        data-bs-toggle="modal" data-bs-target="#modalCriarIlustracao" style="width: 64px; height: 64px;">
    +
</button>

<!-- Modal de Criar Ilustração -->
<div class="modal fade" id="modalCriarIlustracao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Nova Ilustração</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ilustracoes.store', $livro->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Imagem</label>
                        <input type="file" class="form-control" name="imagem" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Ilustração</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para exibir a ilustração ampliada -->
<div class="modal fade" id="modalExibirIlustracao" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img id="imagemAmpliada" class="img-fluid w-100" alt="Ilustração ampliada">
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.ilustracao-click').forEach(img => {
        img.addEventListener('click', function () {
            document.getElementById('imagemAmpliada').src = this.getAttribute('data-src');
        });
    });
</script>

@endsection
