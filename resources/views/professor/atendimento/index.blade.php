@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content')
    <section class="content"  id="app" >
            @if(isset($data['sala_ativa']))
                <professor user_id="{{ Auth::user()->id }}"  aula_id="{{ $data['sala_ativa']->aula_id }}" root=" {{ env('APP_URL') }}"></professor>
            @else
                <div class="row p-3">
                    <div  class="col-12 text-center alert alert-success m-2" role="alert">
                        <h5 class="py-3">Nenhuma Aula ativa no momento</h5>
                    </div>
                    <div  class="col-12 text-center">
                        <a href="{{ route('professor.aula.create')}}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Cadastre Sua Mesa</a>
                    </div>
                </div>
            @endif
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{ asset('js/professor/app.js') }}" ></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" ></script>
    <script src="{{ asset('plugin/jquery.mask.min.js') }}" ></script>
    <script src="{{ asset('js/scripts.js') }}" ></script>
@stop
