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
                            <a href="{{ route('professor.atendimento.index')}}" class="btn btn-primary btn-xs"><span class="fas fa-plus"></span> Novo Cadastro</a>
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

                                <th>Início</th>
                                <th>Fim</th>
                                <th class="text-center">
                                   <span class="px-1" data-toggle="tooltip" data-placement="top" title="Senhas">S</span> -
                                   <span class="px-1" data-toggle="tooltip" data-placement="top" title="Atendidos">A</span> -
                                   <span class="px-1" data-toggle="tooltip" data-placement="top" title="Não Atendidos">NA</span> -
                                   <span class="px-1" data-toggle="tooltip" data-placement="top" title="Desistentes">D</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id}} - {{ \Carbon\Carbon::parse($item['inicio'])->format('d/m/Y')}}</td>
                                    <td>{{ $item['sala']['titulo']}}</td>
                                    <td>{{ $item['disciplina']['titulo']}}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['inicio'])->format('H:i')}}</td>
                                    <td>@if($item['fim']){{ \Carbon\Carbon::parse($item['fim'])->format('H:i')}}@else Não Finalizado @endif</td>
                                    <td class="text-center">
                                        <span class="px-1" data-toggle="tooltip" data-placement="top" title="Senhas">{{ $item->senhas->count() }}</span> -
                                        <span class="px-1" data-toggle="tooltip" data-placement="top" title="Atendidos">{{ $item->atendidos->count() }}</span> -
                                        <span class="px-1" data-toggle="tooltip" data-placement="top" title="Não Atendidos">{{ $item->naoAtendidos->count() }}</span> -
                                        <span class="px-1" data-toggle="tooltip" data-placement="top" title="Desistentes">{{ $item->desistentes->count() }}</span>
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
                <!-- /.card-body -->

                <div class="row">
                    <div class="col-12 p-4 ">
                        {{ $data->links() }}
                    </div>
                </div>

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
        $(function () {
            $('[data-toggle="tooltip"]').css("cursor","pointer")
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
