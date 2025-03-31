@extends('layouts.app')

@section('title', 'Pessoas Excluídas')

@section('header')
<h1 class="d-flex align-items-center me-4">
    Pessoas Excluídas
</h1>
@endsection

@section('content')

@if ($pessoas->isEmpty())
<p class="text-danger">Nenhuma pessoa excluída.</p>
@else
<div class="row justify-content-center mt-4">
    @foreach ($pessoas as $pessoa)
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-slash text-danger me-2"></i> {{ $pessoa->nome }}
                </h5>
            </div>
            <div class="card-body">
                <p><strong><i></i> Email:</strong> {{ $pessoa->email }}</p>
                <p><strong><i></i> CPF:</strong> {{ $pessoa->cpf }}</p>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <!-- Restaurar -->
                <form action="{{ route('admin.restore.single', $pessoa->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="fas fa-undo"></i> Restaurar
                    </button>
                </form>

                <!-- Excluir Permanentemente -->
                <form action="{{ route('admin.forceDelete', $pessoa->id) }}" method="POST"
                    onsubmit="return confirm('Tem certeza que deseja excluir permanentemente? Esta ação não pode ser desfeita.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<a href="{{ route('admin.listar') }}" class="btn btn-primary mt-3">
    <i class="fas fa-arrow-left"></i> Voltar para a Listagem
</a>

@endsection