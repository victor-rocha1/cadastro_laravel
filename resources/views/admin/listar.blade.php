@extends('layouts.app')

@section('title', 'Listagem de Pessoas')

@section('header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Listagem de Pessoas</h1>
    <a href="{{ route('admin.restore') }}" class="btn btn-info btn-sm d-flex align-items-center">
        <i class="fas fa-history me-2"></i> Histórico de Excluídos
    </a>
</div>
@endsection

@section('content')

@if ($pessoas->isEmpty())
    <p class="text-danger text-center">Nenhuma pessoa cadastrada.</p>
@else

    <div class="row justify-content-center mt-4">
        @foreach ($pessoas as $pessoa)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 d-flex align-items-center gap-2">
                        {{ $pessoa->nome }}

                        @if($pessoa->trashed())
                        <form action="{{ route('admin.restore.single', $pessoa->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm d-flex align-items-center">
                                <i class="fas fa-history"></i> Restaurar
                            </button>
                        </form>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> {{ $pessoa->email }}</p>
                    <p><strong>CPF:</strong> {{ $pessoa->cpf }}</p>
                </div>
                <div class="card-footer d-flex gap-2">
                    <!-- Editar -->
                    <a href="{{ route('admin.edit', $pessoa->id) }}" class="btn btn-warning btn-sm d-flex align-items-center">
                        <i class="fas fa-edit"></i>
                    </a>

                    <!-- Deletar -->
                    <form action="{{ route('admin.destroy', $pessoa->id) }}" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja excluir esta pessoa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

<a href="{{ route('home') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Voltar para a Página Inicial
</a>

@endsection