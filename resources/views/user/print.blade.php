@extends('adminlte::page')
@section('title','Correspondencia Recibida')
@section('content')
<div class="card p-5" style="text-transform: uppercase;">
    <div class="row">
        <div class="col-2">
            <img src="{{ asset('logo_docs.png') }}" width="180px" alt="MINAGUAS" class="img img-responsive pull-left">
        </div>
        <div class="col-8">
            <h2 class="text-center">Reporte Hoja de Seguimiento</h2>
            <h5 class="text-center">A la Fecha: {{date("d/m/Y", strtotime(date("Y/m/d")))}}</h5>
        </div>
    </div>
    <div class="card-header">
        <table class="table table-bordered table-striped">
            <thead class="text-center">
                <th colspan="2">Correspondencia {{$doc->codigo}}</th>
            </thead>
            <tbody>
                <tr>
                  <th style="width: 20%;">Numero de Documento</th>
                  <td>{{$doc->nro_doc}}</td>
                </tr>
                <tr>
                    @if ($doc->destinatario)
                    <th>Destinatario</th>
                    <td>{{$doc->destinatario}}</td>
                    @elseif($doc->remitente)
                    <th>Remitente</th>
                    <td>{{$doc->remitente}}</td>
                    @endif
                </tr>
                <tr>
                  <th>Referencia</th>
                  <td>{{$doc->referencia}}</td>
                </tr>
                @if ($doc->fecha_rec)
                <tr>
                    <th>Fecha de Recepción</th>
                    <td>{{$doc->fecha_rec}}</td>
                </tr>
                @endif
                <tr>
                  <th>Fecha del Documento</th>
                  <td>{{$doc->fecha_doc}}</td>
                </tr>
                <tr>
                  <th>Tipo de Correspondencia</th>
                  <td>{{$doc->tipo}}</td>
                </tr>
                @if ($doc->estado)
                <tr>
                    <th>Estado</th>
                    <td>{{$doc->estado}}</td>
                </tr>
                @endif
                <tr>
                  <th>Acción</th>
                  <td>{{$doc->accion}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="card">
        <div class="card-header text-center">
            <h3>Seguimientos Realizados al Documento {{$doc->codigo}}</h3>
        </div>
        <div class="card-body">
            <table class="text-center table table-bordered table-striped">
                <thead>
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
                                <td class="">{{$seguimiento->estatus}}</td>                                                   
                            </tr>
                            @endif
                        @endforeach 
                    @endif
                    
                </tbody>
            </table>
        </div>
    </div>    
</div>
@stop
@section('css')
@stop
@section('js')
@stop