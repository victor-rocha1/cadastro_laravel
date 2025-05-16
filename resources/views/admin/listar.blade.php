@extends('master')

@section('content')
<div id="lista-app"
    data-pessoas='@json($pessoas)'
    data-success-message="{{ session('success') }}"
    data-csrf="{{ csrf_token() }}">
</div>
<script>
    window.pessoas = JSON.parse('@json($pessoas)');
</script>


@endsection