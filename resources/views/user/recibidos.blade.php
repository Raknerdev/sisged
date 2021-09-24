@extends('adminlte::page')

@section('title','Correspondencia Recibida')
@section('content_header')

@stop
@section('content')
<div class="modal" id="creacion" tabindex="-1" style="text-transform: uppercase;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <div class="mx-auto pl-5">
                <h5 class="modal-title ml-5 pl-3">Registro de Correspondencia Recibida</h5>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('add_recibido') }}" name="recibido" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="card-body pt-0 pb-0">
              <div class="row">
                  {{-- Izquierda --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tipo">Tipo de Correspondencia:</label>
                      <select class="form-control select2" name="tipo" onchange="mEstados(this.value);" style="width: 100%;" required>
                        <option value="0" selected disabled>SELECCIONE...
                        <option value="1">INTERNA</option>
                        <option value="2">EXTERNA</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="remitente">Remitente:</label>
                      <select class="form-control select2" name="remitente" id="rem" style="width: 100%; text-transform: uppercase;" required>
                        <option value="-">- 
                      </select>
                    </div>
                    <div class="form-group" id="estado" style="display: none;">
                      <label for="estado">Estado:</label>
                      <select class="form-control select2" name="estado" id="estados" style="width: 100%; text-transform: uppercase;">
                        <option value="-">- 
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="otro">Dato Adicional:</label>
                      <input type="text" name="otro" class="form-control" placeholder="DATO ADICIONAL..." style="text-transform: uppercase;" required>
                    </div>
                    <div class="form-group">
                      <label for="recibido_por">Recibido por:</label>
                      <input type="text" name="recibido_por" class="form-control" value="{{Auth::user()->name}}" style="text-transform: uppercase;" disabled>
                    </div>
                    <div class="form-group">
                      <label for="referencia">Referencia:</label>
                      <textarea name="referencia" class="form-control" cols="30" rows="4" placeholder="DESCRIPCIÓN CORTA DEL DOCUMENTO" maxlength="320" style="text-transform: uppercase;" required></textarea>
                    </div>
                    {{-- <div class="form-group">
                      <label for="ccopia_a">Con Copia:</label>
                      <select class="form-control select2" name="ccopia_a" onchange="copia_a(this.value);" style="width: 100%;" required>
                        <option value="0" selected disabled>SELECCIONE...
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                      </select>
                    </div>
                    <div id="ccopy" style="display: none;">
                      <div class="form-group">
                        <label for="copy">Copia:</label>
                        <select class="form-control select2" name="copy" onchange="copia()" style="width: 100%;">
                          <option value="0" selected disabled>SELECCIONE...
                          <option value="1">INTERNA</option>
                          <option value="2">EXTERNA</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="ccopia">Copia a:</label>
                        <select class="form-control select2" name="ccopia" style="width: 100%;">
                          <option value="-">- 
                        </select>
                      </div>
                    </div> --}}
                    <div class="form-group">
                      <label for="bandeja_de">Bandeja de:</label>
                      <select class="form-control select2" name="bandeja_de" id="c_der" style="width: 100%; text-transform: uppercase;">
                      </select>
                    </div>
                  </div>
                  {{-- Derecha --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="file">Documento:</label>
                      <input type="file" name="file" class="custom-file" id="archivo" required>
                    </div>
                    <div class="form-group">
                      <label for="tipo_doc">Tipo de Documento:</label>
                      <select class="form-control select2" name="tipo_doc" style="width: 100%;" required>
                        <option value="CIRCULAR">CIRCULAR</option>
                        <option value="DENUNCIA">DENUNCIA</option>
                        <option value="INFORME">INFORME</option>
                        <option value="MEMORANDO">MEMORANDO</option>
                        <option value="OFICIO">OFICIO</option>
                        <option value="PUNTO DE CUENTA">PUNTO DE CUENTA</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_doc">Fecha del Documento:</label>
                        <input type="date" name="fecha_doc" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="fecha_rec">Fecha de Recibido:</label>
                      <input type="date" name="fecha_rec" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nro_doc">Nro. de Documento:</label>
                        <input type="text" name="nro_doc" class="form-control" placeholder="DOC_WF54-542" style="text-transform: uppercase;" required>
                    </div>
                    <div class="form-group">
                        <label for="estatus">Estatus:</label>
                        <select class="form-control select2" name="estatus" style="width: 100%;" required>
                          <option value="ABIERTO" selected>ABIERTO</option>
                          <option value="CERRADO">CERRADO</option>
                          <option value="PENDIENTE">PENDIENTE</option>
                          <option value="EXPIRADO">EXPIRADO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="accion">Acción:</label>
                        <select class="form-control select2" name="accion" style="width: 100%;" onChange="mostrar(this.value);" required>
                          <option value="EVALUAR Y RECOMENDAR" selected>EVALUAR Y RECOMENDAR</option>
                          <option value="CIRCULAR">CIRCULAR</option>
                          <option value="RESPUESTA A">RESPUESTA A</option>
                          <option value="REQUIERE RESPUESTA">REQUIERE RESPUESTA</option>
                          <option value="ARCHIVAR">ARCHIVAR</option>
                        </select>
                    </div>
                    <div id="obsres" style="display: none;">
                      <div class="form-group">
                        <label for="ref_doc">REFERENCIA DE RESPUESTA:</label>
                        <input id="ref_doc" type="text" style="text-transform:uppercase;" class="form-control" name="ref_doc">
                      </div>
                    </div>
                    <div id="obsfec" style="display: none;">
                      <div class="form-group">
                        <label for="fecha_lim">FECHA LIMITE PARA RESPONDER:</label>
                        <input id="fecha_lim" type="date" class="form-control"  name="fecha_lim">
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="seguimiento">Seguimiento:</label>
                        <select class="form-control select2" name="seguimiento" style="width: 100%;" required>
                          <option value="REVISAR INFORMACION" selected>REVISAR INFORMACION</option>
                          <option value="DERIVAR">DERIVAR</option>
                          <option value="DERIVAR">ARCHIVAR</option>
                          <option value="REGISTRAR CORRESPONDENCIA">REGISTRAR CORRESPONDENCIA</option>
                        </select>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- @if (Auth::user()->ROLE == 'Admin') --}}
  <div class="modal fade" id="mod_eliminar" tabindex="-1" role="dialog" aria-labelledby="creacionLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center" >Eliminar Correspondencia</h4>
        </div>
        
        <div class="modal-body">
          <input name="_method" type="hidden"  value="DELETE" id="input_eliminar">
            {{-- <form class="form-horizontal" id="form-delete" role="form" method="POST" action="{{ route('apis.destroy', ':USER_ID') }}"> --}}
              <input name="_method" type="hidden"  value="DELETE">
              <input name="_token" type="hidden" value="{{ csrf_token() }}">
            </form>
            <button type="submit" class="btn btn-danger btn-block" data-dismiss="modal" id="btn-eliminarr">Eliminar</button>
            </div>
              <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  {{-- @endif --}}

    {{-- Tabla --}}
    <div class="card mt-3">
      <small>
      <div class="card-header">
        <div class="float-left">
          <h4>CORRESPONDENCIA RECIBIDA</h4>
        </div>
        <div class="float-right">
          <button type="button" class="btn btn-success" id="btn-creacion" data-toggle="modal" data-target="#creacion" name="button">NUEVO INGRESO</button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row"><div class="col-sm-12 col-md-6"></div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
              <thead>
                <tr class="text-center">
                  <th>CODIGO</th>
                  <th>DOCUMENTO</th>
                  <th>TIPO</th>
                  <th>REMITENTE</th>
                  <th>ESTADO</th>
                  <th>REFERENCIA</th>
                  <th>ESTATUS</th>
                  <th>OPCIONES</th>
                </tr>
              </thead>
              <tbody style="text-transform: uppercase;">
                @if ($recibidos)
                  @foreach ($recibidos as $recibido)
                    @if ($recibido->active == 1)
                    <tr>
                      <td>{{$recibido->codigo}}</td>
                      <td>{{$recibido->nro_doc}}</td>
                      <td>{{$recibido->tipo}}</td>
                      <td>{{$recibido->remitente}}</td>
                      <td>{{$recibido->estado}}</td>
                      <td>{{$recibido->referencia}}</td>
                      <td>{{$recibido->estatus}}</td>
                      <td class="text-center">
                        <a href="{{ route('seguimiento_re', ['id'=>encrypt("$recibido->id")]) }}" class="btn btn-sm btn-primary fas fa-file-word"> <span style="font-family: 'Oswald', sans-serif !important;"></span></a>
                        @if (Auth::user()->ROLE == 'Root')
                        <a class="btn-sm btn-danger fas fa-trash-alt" id="eliminar"> ELIMINAR</a>
                        @endif
                      </td>
                    </tr>
                    @endif
                  @endforeach    
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </small>
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
  <script src="{{ asset("js/jquery/jquery.js") }}"></script>
  <script type="text/javascript">
    function mostrar(id){ 
      if (id == "EVALUAR Y RECOMENDAR"){
        $("#obsres").hide();
        $("#obsfec").hide();
      }
      if (id == "CIRCULAR"){
        $("#obsres").hide();
        $("#obsfec").hide();
      }
      if (id == "REQUIERE RESPUESTA") {
        $("#obsfec").show();
        $("#obsres").hide();
      }
      if (id == "RESPUESTA A"){ 
        $("#obsres").show();
        $("#obsfec").hide();
      }
      if (id == "ARCHIVAR"){
        $("#obsres").hide();
        $("#obsfec").hide();
      }
    }
    function mEstados(id){
      var urlEInternos = "{{ url('get/externos')}}";
      var urlEExternos = "{{ url('get/internos')}}";
      var $el = $("#rem");
      if (id == 2){
        $("#estado").show();
        $(function () {
          $.get(urlEExternos, function(data, status)
          {
            $el.empty(); // remove old options
            $.each(data, function(key,value) {
              $el.append($("<option></option>")
                 .attr("value", value.name).text(value.name));
            });
             console.log(data);
          });
        });
      }else{
        $("#estado").hide();
        $(function () {
          $.get(urlEInternos, function(data, status)
          {
            $el.empty(); // remove old options
            $.each(data, function(key,value) {
              $el.append($("<option></option>")
                 .attr("value", value.name).text(value.name));
            });
             console.log(data);
          }).fail(function()
          {
             console.log("Error");
          });
        });
      }
    }
  </script>
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
      $('#users-table tbody').on('click', 'td>a.btneliminar', function () {
          event.preventDefault();
          var id = $(this).attr('id');

          id = id.substring(1);
          $('#input_eliminar').val(id);
        });
        $('#btn-eliminarr').on('click', function () {
            event.preventDefault();

            var id = $('#input_eliminar').val();
            var row = $('#e'+id).parents('tr');
            var form = $('#form-delete');
            var url = form.attr('action').replace(':USER_ID', id);
            var data = form.serialize();
            $.post(url, data, function(result)
            {
              row.fadeOut();
              console.log(result);
            }).fail(function()
            {
                row.show();
            });
          });
      $('#btn-creacion').on('click', function () {
          event.preventDefault();
          var url =  "{{ url('get/users')}}";
          var urlEstados =  "{{ url('get/estados')}}";
          // console.log(url);
          $.get(url, function(data, status)
          {
            var $el = $("#c_der");
            $el.empty(); // remove old options
            $.each(data, function(key,value) {
              $el.append($("<option></option>")
                 .attr("value", key+1).text(value.name));
            });
             console.log(data);
          }).fail(function()
          {
             console.log("Error");
          });
          $.get(urlEstados, function(data, status)
          {
            var $el = $("#estados");
            $el.empty(); // remove old options
            $.each(data, function(key,value) {
              $el.append($("<option></option>")
                 .attr("value", value.nombre).text(value.nombre));
            });
             console.log(data);
          }).fail(function()
          {
             console.log("Error");
          });
        });
      
    });
  </script>
@stop