@extends('layouts.app')

@section('title', 'Listagem de Pessoas')

@section('header', 'Listagem de Pessoas')

@section('content')

@if ($pessoas->isEmpty())
<p class="text-danger">Nenhuma pessoa cadastrada.</p>
@else


<div class="row justify-content-center mt-5">
    @foreach ($pessoas as $pessoa)
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ $pessoa->nome }}</h5>
                <div class="d-flex gap-2">
                    <!-- editar -->
                    <a href="{{ route('admin.edit', $pessoa->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>

                    <!-- deletar -->
                    <form action="{{ route('admin.destroy', $pessoa->id) }}" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja excluir esta pessoa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
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

<a href="{{ route('home') }}" class="btn btn-secondary mt-3">
    <i class="fas fa-arrow-left"></i> Voltar para a Página Inicial
</a>


@endsection