@extends('layouts.app')

@section('title', 'Pessoas Excluídas')

@section('header')
<h1 class="d-flex align-items-center justify-content-between me-4">
    Pessoas Excluídas
    <a href="{{ route('admin.listar') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Voltar para a Listagem
    </a>
</h1>
@endsection

@section('content')

@if ($pessoas->isEmpty())
    <p class="text-danger text-center">Nenhuma pessoa excluída.</p>
@else
    <div class="row justify-content-center mt-5">
        @foreach ($pessoas as $pessoa)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ $pessoa->nome }}</h5>
                    <form action="{{ route('admin.restore.single', $pessoa->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm d-flex align-items-center justify-content-center">
                            <i class="fas fa-history me-2"></i> Restaurar
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> {{ $pessoa->email }}</p>
                    <p><strong>CPF:</strong> {{ $pessoa->cpf }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection