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

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0 ">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- id, disciplina_id, teacher_id, sala_id, titulo, inicio, date, fim, status, created_by, created_at, updated_at --}}

                    @if(isset($data) && count($data))
                        <table class="table table-striped ">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Mesa</th>

                                <th>Disciplina</th>

                                <th>Professor</th>
                                <th>Operações</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td >{{ \Carbon\Carbon::parse($item['inicio'])->format('d/m/Y')}}</td>

                                    <td>{{ $item->sala->titulo }}</td>
                                    <td>{{ $item->disciplina->titulo }}</td>

                                    <td>{{ $item->professor->name }}</td>
                                    <td>
                                        @if($item['status'])
                                            <form id="logout-form-{{ $item['sala_id'] }}" action="{{ route($params['main_route'].'.desativar',$item['id']) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="sala_id" value="{{ $item['sala_id'] }}">
                                                <button type="submit" class="btn btn-primary btn-xs" >Desativar</button>
                                            </form>
                                        @else
                                            <form id="logout-form-{{ $item['sala_id'] }}" action="{{ route($params['main_route'].'.ativar',$item['id']) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="sala_id" value="{{ $item['sala_id'] }}">
                                                <input type="hidden" name="professor_id" value="{{ $item['professor_id'] }}">
                                                <button type="submit" class="btn btn-danger btn-xs" >Ativar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach



                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-success m-2" role="alert">
                            Nenhuma informação cadastrada.
                        </div>
                    @endif

                </div>
                <div class="box-footer clearfix d-flex justify-content p-3">
                    {!! $data->links() !!}
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
