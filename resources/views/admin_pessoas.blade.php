@extends('layouts.app')

@section('title', 'Listagem de Pessoas')

@section('header', 'Listagem de Pessoas')

@section('content')

@if (!empty($erro))
    <p style="color: red;">{{ $erro }}</p>
@else
    @if($pessoas->isEmpty())
        <p>Nenhuma pessoa cadastrada.</p>
    @else
        <div class="row">
            @foreach ($pessoas as $pessoa)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ $pessoa->nome }}</h5>
                            <div class="d-flex">
                                <!-- Botão de editar (sem lógica de edição ainda) -->
                                <button class="btn btn-warning btn-sm mr-2">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <!-- Botão de excluir (sem lógica de exclusão ainda) -->
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Excluir
                                </button>
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
@endif

<a href="{{ route('home') }}" class="btn btn-secondary mt-3">Voltar para a Página Inicial</a>

@endsection

@section('styles')
    <!-- link dos ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection