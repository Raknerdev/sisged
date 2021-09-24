@extends('adminlte::page')

@section('title','Seguimiento')
@section('content_header')

@stop
@section('content')
<div class="content mt-3 mb-3" style="text-transform: uppercase;">
    <div class="container-fluid">
        <div class="row">
            {{--  Detalles  --}}
            <div class="col-md-6">
                <small>
                <div class="card card-primary card-outline shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">
                                Documento {{$doc->nro_doc}}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 33%">CODIGO DE DOCUMENTO</th>
                                    <td>{{$doc->nro_doc}}</td>
                                </tr>
                                @if ($doc->destinatario)
                                <tr>
                                    <th>DESTINATARIO</th>
                                    <td>{{$doc->destinatario}}</td>
                                </tr>
                                @elseif($doc->remitente)
                                <tr>
                                    <th>REMITENTE</th>
                                    <td>{{$doc->remitente}}</td>
                                </tr>
                                @endif
                                @if ($doc->estado  != null && $doc->estado  != '-')
                                    <tr>
                                        <th>ESTADO</th>
                                        <td>{{$doc->estado}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>REFERENCIA</th>
                                    <td>{{$doc->referencia}}</td>
                                </tr>
                                <tr>
                                    @if ($doc->destinatario)
                                    <th>REGISTRADA POR</th>
                                    @else
                                    <th>RECIBIDO POR</th>
                                    @endif
                                    @foreach ($users as $user)
                                        @if ($user->id == $doc->recibido_por)
                                        <td>{{$user->name}}</td>
                                        @endif
                                    @endforeach
                                    
                                </tr>
                                <tr>
                                    <th>TIPO DE CORRESPONDENCIA</th>
                                    <td>{{$doc->tipo}}</td>
                                </tr>
                                <tr>
                                    <th>ESTATUS</th>
                                    <td>{{$doc->estatus}}</td>
                                </tr>
                                @if ($doc->fecha_rec)
                                <tr>
                                    <th>FECHA DE RECEPCIÓN</th>
                                    <td>{{date("d/m/Y", strtotime($doc->fecha_rec))}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>FECHA DEL DOCUMENTO</th>
                                    <td>{{date("d/m/Y", strtotime($doc->fecha_doc))}}</td>
                                </tr>
                                <tr>
                                    <th>ARCHIVO</th>
                                    <td>
                                        @if ($doc->destinatario)
                                        <a href="{{ route('download_env',['uuid'=>$doc->uuid])}}">{{$doc->file}} </a>
                                        @elseif($doc->remitente)
                                        <a href="{{ route('download_res',['uuid'=>$doc->uuid])}}">{{$doc->file}} </a>    
                                        @endif
                                    </td>
                                </tr>
                                @if ($doc->destinatario)
                                <tr>
                                    <th>COPIA A</th>
                                    @if ($doc->ccopia == "-")
                                    <td>SIN COPIA</td>
                                    @else
                                    <td>{{$doc->ccopia}}</td>
                                    @endif
                                </tr>
                                @endif
                                <tr>
                                    <th>ACCIÓN</th>
                                    @if ($doc->accion == 'RESPUESTA A')
                                    <td>{{$doc->accion . ' EL DOCUMENTO ' . $doc->ref_doc}}</td>
                                    @elseif($doc->accion == 'REQUIERE RESPUESTA')
                                    <td>{{$doc->accion . ' PARA LA FECHA ' . $doc->fecha_lim}}</td>
                                    @else
                                    <td>{{$doc->accion}}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($doc->destinatario)
                    <a href="{{ route('print_env', ['id'=>encrypt("$doc->id")]) }}" class="card-footer btn bg-gradient-primary btn-block text-bold text-black-75">IMPRIMIR HOJA DE SEGUIMIENTOS</a>
                    @elseif($doc->remitente)
                    <a href="{{ route('print_rec', ['id'=>encrypt("$doc->id")]) }}" class="card-footer btn bg-gradient-primary btn-block text-bold text-black-75">IMPRIMIR HOJA DE SEGUIMIENTOS</a>
                    @endif
                    
                </div>
            </small>
            </div>
            {{--  Seguimientos  --}}
            <div class="col-md-6"><small>
                @if ($doc->estatus == 'ABIERTO')
                <div class="card card-green card-outline shadow">
                @elseif ($doc->estatus == 'CERRADO')
                <div class="card card-primary card-outline shadow">
                @elseif ($doc->estatus == 'PENDIENTE')
                <div class="card card-warning card-outline shadow">
                @elseif ($doc->estatus == 'EXPIRADO')
                <div class="card card-danger card-outline shadow">
                @endif
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">
                                Nuevo Seguimiento de Documento {{$doc->nro_doc}}
                            </h3>
                        </div>
                    </div>
                    @if ($doc->destinatario)
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('add_seguimiento_en', ['id'=>encrypt("$doc->id")]) }}" enctype="multipart/form-data">
                    @elseif($doc->remitente) 
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('add_seguimiento_re', ['id'=>encrypt("$doc->id")]) }}" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="card-body ">
                            <div class="form-group row">
                                <label for="file" class="col-sm-4 text-right mt-1 mr-3 control-label">Documento:</label>
                                <input type="file" name="file" class="col-sm-7" id="archivo">
                            </div>
                            <div class="form-group row">
                                <label for="estatus" class="col-sm-4 text-right mt-1 mr-3 control-label">ESTATUS</label>
                                <select class="form-control col-sm-7" name="estatus"  required>
                                    <option disabled>SELECCIONE...</option>
                                    <option value="ABIERTO">ABIERTO</option>
                                    @if (Auth::user()->ROLE == 'Admin' || Auth::user()->ROLE == 'Root')
                                    <option value="CERRADO">CERRADO</option>
                                    @endif
                                    <option value="PENDIENTE">PENDIENTE</option>
                                    <option value="EXPIRADO">EXPIRADO</option>
                                </select>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="seguimiento" class="col-sm-4 text-right mt-1 mr-3 control-label">Seguimiento</label>
                                <select class="form-control col-sm-7" name="seguimiento"  required>
                                    <option selected disabled>SELECCIONE...</option>
                                  <option value="REVISAR INFORMACION">REVISAR INFORMACION</option>
                                  <option value="DERIVAR">DERIVAR</option>
                                  <option value="DERIVAR">ARCHIVAR</option>
                                  <option value="REGISTRAR CORRESPONDENCIA">REGISTRAR CORRESPONDENCIA</option>
                                </select>
                            </div> --}}
                            <div class="form-group row">
                                <label for="accion" class="col-sm-4 text-right mt-1 mr-3 control-label">Acción</label>
                                <select class="form-control col-sm-7" name="accion"  required>
                                    <option disabled>SELECCIONE...</option>
                                    <option value="EVALUAR Y RECOMENDAR">EVALUAR Y RECOMENDAR</option>
                                    <option value="CIRCULAR">CIRCULAR</option>
                                    <option value="REQUIERE RESPUESTA">REQUIERE RESPUESTA</option>
                                    <option value="RESPUESTA A">RESPUESTA A</option>
                                    <option value="ARCHIVAR">ARCHIVAR</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="instruccion" class="col-sm-4 text-right mt-1 mr-3 control-label">INSTRUCCIÓN</label>
                                <input type="text" name="instruccion" class="form-control col-sm-7" style="text-transform: uppercase;">
                            </div>
                            <div class="form-group row">
                                <label for="bandeja_de" class="col-sm-4 text-right mt-1 mr-3 control-label">BANDEJA DE</label>
                                <select class="form-control col-sm-7" id="c_der" name="bandeja_de" style="text-transform: uppercase;" required>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if ($doc->estatus <= $doc->fecha_lim)
                        <button disabled type="submit" class="card-footer btn bg-gradient-danger btn-block text-bold">
                            EXPIRADO
                        </button>
                        @elseif ($doc->estatus == 'CERRADO')
                        <button disabled type="submit" class="card-footer btn bg-gradient-primary btn-block text-bold text-black-75">
                            CERRADO
                        </button>
                        @elseif ($doc->estatus == 'EXPIRADO')
                        <button disabled type="submit" class="card-footer btn bg-gradient-danger btn-block text-bold text-black-75">
                            EXPIRADO
                        </button>
                        @elseif ($doc->estatus == 'PENDIENTE')
                        <button type="submit" class="card-footer btn bg-gradient-warning btn-block text-bold text-white">
                            Actualizar
                        </button>
                        @elseif ($doc->estatus == 'ABIERTO')
                        <button type="submit" class="card-footer btn bg-gradient-green btn-block text-bold text-white">
                            Actualizar
                        </button>                        
                        @endif
                    </form>
                </div></small>
            </div>
        </div>
    </div>
    <table class="text-center table table-bordered table-striped mt-5 mb-5 shadow">
        <thead>
            <tr>
                <th colspan="9" class=" bg-gradient-success">Seguimientos Realizados al Documento {{$doc->codigo}}</th>
            </tr>
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 10%">USUARIO</th>
                <th style="width: 12%">ACCIÓN</th>
                <th style="width: 12%">FECHA</th>
                <th style="width: 15%">BANDEJA DE</th>
                <th style="width: 36%">INSTRUCCIÓN</th>
                <th style="width: 10%">ESTATUS</th>
            </tr>
        </thead>
        <tbody>
            @if ($seg)
                @php
                    $cont = 0;
                @endphp
                @foreach ($seg as $seguimiento)
                    @if ($seguimiento->id_documento == $doc->id && $seguimiento->tipo_c == $doc->tipo_c)
                    <tr>
                        <td>{{$cont=$cont+1}}</td>
                        <td>
                            @foreach ($users as $user)
                                @if ($user->id == $seguimiento->id_usuario)
                                {{$user->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$seguimiento->accion}}</td>
                        <td>{{date("d/m/Y", strtotime($seguimiento->fecha))}}</td>
                        <td>
                            @foreach ($users as $user)
                                @if ($user->id == $seguimiento->bandeja_de)
                                {{$user->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$seguimiento->instruccion}}</td>
                        @if ($seguimiento->estatus == 'ABIERTO')
                        <td class="bg-green">{{$seguimiento->estatus}}</td>
                        @elseif ($seguimiento->estatus == 'CERRADO')
                        <td class="bg-primary">{{$seguimiento->estatus}}</td>
                        @elseif ($seguimiento->estatus == 'PENDIENTE')
                        <td class="bg-warning"><span class="text-white">{{$seguimiento->estatus}}</span></td>
                        @elseif ($seguimiento->estatus == 'EXPIRADO')
                        <td class="bg-danger">{{$seguimiento->estatus}}</td>
                        @endif
                                            
                    </tr>
                    @endif
                @endforeach 
            @endif
            
        </tbody>
    </table>
</div>
@stop
@section('css')
<link rel="icon" href="{{asset("favicon_500x500.png")}}" type="image/png"/>
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="{{ asset('theme/lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('theme/lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('theme/lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('theme/lte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset("theme/lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
@stop
@section('js')
<script src="{{ asset('theme/lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('theme/lte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "searching": true,
      "paging": true,
      "ordering": true,
      "info": true,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>
@stop