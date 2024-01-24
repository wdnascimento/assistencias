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
                            <a href="{{ route($params['main_route'].'.create')}}" class="btn btn-primary btn-xs"><span class="fas fa-plus"></span> Novo Cadastro</a>
                        </div>
                    </div>
                    {{ Form::open(['route' => [$params['main_route'].'.index'],'method' =>'GET', 'id' => 'form_filtro']) }}
                    <div class="row">
                        <div class="col-4 pt-3">
                                {{Form::select('turma_id',
                                    $preload['turma_id'],
                                    ((isset($preload['turma'])) ? $preload['turma'] : null),
                                    ['id'=>'turma_id','class' =>'form-control'])}}
                        </div>
                        <div class="col-4 pt-3">
                            {{ Form::text('name',(isset($searchFields['name']) ? $searchFields['name'] : ''), ['class' => 'form-control', 'placeholder' => 'Nome'])}}
                        </div>
                        <div class="col-4 d-flex pt-3 ">
                            {{ Form::submit('Buscar',['class'=>'btn btn-primary btn-md d-flex']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    @if(isset($data) && count($data))
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Ano</th>
                                <th>Turma</th>
                                <th>Número</th>
                                <th>Nome</th>
                                <th>Cabine / Celular</th>
                                <th>Operação</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr @if( $item['send_sms'] == '0' && $item['cabine'] == '0') class="table-warning" @endif title="Aluno sem ensalamento">
                                    <td>{{ $item['ano']}}</td>
                                    <td>{{ $item->turma['titulo']}}</td>
                                    <td>{{ $item['numero']}}</td>
                                    <td>{{ $item['name']}}</td>
                                    @if($item['send_sms'] == '0')
                                    <td ><strong>Cab:</strong> {{ $item['cabine']}}</td>
                                    @else
                                    <td ><strong>Cel:</strong> {{ $item['celular']}}</td>
                                    @endif

                                    <td>
                                        <a href="{{ route($params['main_route'].'.edit', $item['id']) }}" class="btn btn-info btn-xs"><span class="fas fa-edit"></span> Editar</a>
                                        <a href="{{ route($params['main_route'].'.show', $item['id']) }}" class="btn btn-danger btn-xs"><span class="fas fa-trash"></span> Deletar</a>
                                    </td>
                                </tr>
                                @endforeach



                            </tbody>
                        </table>
                        <div class="box-footer clearfix p-3 d-flex justify-content-end align-content-center">
                            {{ $data->appends(request()->all())->links()  }}
                        </div>
                    @else
                        <div class="alert alert-success m-2" role="alert">
                            Nenhuma informação cadastrada.
                        </div>
                    @endif
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
    <script>
        $('#turma_id').on('change', function(){
            $('#form_filtro').submit();
        });
    </script>
@stop
