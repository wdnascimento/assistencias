@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    <section class="content" >
       <div class="row">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">{{$params['subtitulo']}}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route($params['main_route'].'.index')}}" class="btn btn-primary btn-xs"><span class="fas fa-arrow-left"></span>  Voltar</a>
                        </div>
                    </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0 ">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if( isset($data))
                        {{
                            Form::model($data,[
                                'route' => [$params['main_route'].'.update',$data->id]
                                ,'class' => 'form'
                                ,'method' => 'put'
                            ])
                        }}
                    @else
                        {{ Form::open(['route' => $params['main_route'].'.store','method' =>'post']) }}
                    @endif
                    <div class="form-group">
                        {{Form::label('ano', 'Ano')}}
                        {{Form::select('ano',
                                $preload['ano'],
                                ((isset($data->ano)) ? $data->ano : null),
                                ['id'=>'ano','class' =>'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('name', 'Nome')}}
                        {{Form::text('name',null,['class' => 'form-control', 'placeholder' => 'Nome'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('numero', 'Número')}}
                        {{Form::text('numero',null,['class' => 'form-control', 'placeholder' => 'Número'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('cabine', 'Cabine')}}
                        {{Form::text('cabine',null,['class' => 'form-control', 'placeholder' => 'Cabine'])}}
                    </div>
                    @if(! isset($data))
                        <div class="form-group">
                            {{Form::label('password', 'Senha - Somente Números')}}
                            <br>
                            {{Form::password('password',['class' => 'form-control'])}}
                        </div>
                    @else
                        <div class="form-group text-left">
                            {{Form::label('trocar_senha_aluno', 'Trocar Senha?')}}
                            <br>
                            {{Form::checkbox('trocar_senha_aluno',1,false)}}
                        </div>
                        <div id="update_password_aluno" class="form-group">
                            {{Form::label('password_aluno', 'Senha - Somente Números')}}
                            <br>
                            {{Form::password('password_aluno',['class' => 'form-control'])}}
                        </div>

                    @endif

                    <div class="form-group">
                        {{Form::submit('Salvar',['class'=>'btn btn-success btn-sm'])}}
                    </div>
                    {{ Form::close() }}
                </div>
                <!-- /.card-body -->
              </div>


           </div>
       </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{ asset('plugin/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
@stop
