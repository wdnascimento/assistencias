@extends('layouts.aluno')

@section('content')

    <h3 class="col-12 pt-3 text-center">Olá  {{ Auth::user()->name }}</h3>
    <div id="app" class="container pt-5">
        <aluno user_id="{{ Auth::user()->id }}" turma_id="{{ Auth::user()->turma_id }}" root=" {{ env('APP_URL') }}"></aluno>
    </div>
@endsection
