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

                    {{-- id, disciplina_id, teacher_id, sala_id, titulo, inicio, fim, status, created_by, created_at, updated_at --}}

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
                        {{Form::label('disciplina_id', 'Disciplina')}}
                        {{Form::select('disciplina_id',
                                $preload['disciplinas'],
                                ((isset($data->disciplina_id)) ? $data->disciplina_id : null),
                                ['id'=>'disciplina_id','class' =>'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('sala_id', 'Mesa')}}
                        {{Form::select('sala_id',
                                $preload['salas'],
                                ((isset($data->sala_id)) ? $data->sala_id : null),
                                ['id'=>'sala_id','class' =>'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('professor_id', 'Professor')}}
                        {{Form::select('professor_id',
                                $preload['professores'],
                                ((isset($data->professor_id)) ? $data->professor_id : null),
                                ['id'=>'professor_id','class' =>'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::submit('Iniciar',['class'=>'btn btn-success btn-sm'])}}
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

@stop
