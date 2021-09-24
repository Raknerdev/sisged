<?php

namespace App\Http\Controllers\user;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\docs\enviados;
use App\Models\docs\recibidos;
use App\Models\docs\files;
use App\Models\docs\seguimientos;
use App\Models\regiones\estados;
use App\Models\institucion\EntesInternos;
use App\Models\institucion\EntesExternos;


class UserController extends Controller
{



    public function enviados()
    {
        $enviados = enviados::orderBy('id')->get();
        return view('user/enviadas', compact('enviados'));
    }
    public function recibidos()
    {
        $recibidos = recibidos::orderBy('id')->get();
        return view('user/recibidos', compact('recibidos'));
    }
    public function seguimientos_en($id)
    {
        $id_doc = decrypt($id);
        $doc = enviados::find($id_doc);
        $seg = seguimientos::orderBy('id')->get();
        $users = User::get();
        return view('user/seguimientos', compact('doc','seg','users'));
    }
    public function seguimientos_re($id)
    {
        $id_doc = decrypt($id);
        $doc = recibidos::find($id_doc);
        $seg = seguimientos::orderBy('id')->get();
        $users = User::get();
        return view('user/seguimientos', compact('doc','seg','users'));
    }
    public function add_seguimiento_en(Request $request, $id)
    {
        $id_doc = decrypt($id);
        $doc = enviados::find($id_doc);
        $seg = new seguimientos();

        if ($request->hasFile('file')) {
            $doc['file'] = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('correspondencia',$doc['file']);
        }

        $doc->estatus = $request->estatus;
        $doc->bandeja_de = $request->bandeja_de;
        $doc->accion = $request->accion;
        // $doc->seguimiento = $request->seguimiento;
        $seg->tipo_c = 1;
        $seg->estatus = $request->estatus;
        $seg->accion = $request->accion;
        $seg->bandeja_de = $request->bandeja_de;
        $seg->id_usuario = Auth::id();
        $seg->id_documento = $id_doc;
        $seg->fecha = date("Y/m/d");
        // $seg->seguimiento = $request->seguimiento;
        //$doc->file = $request->file;
        if ($request->instruccion != null) {
            $doc->referencia = $request->instruccion;
            $seg->instruccion = $request->instruccion;
        }else{
            $seg->instruccion = $doc->referencia;
        }
        $doc->save();
        $seg->save();
        return back();
    }
    public function add_seguimiento_re(Request $request, $id)
    {
        $id_doc = decrypt($id);
        $doc = recibidos::find($id_doc);
        $seg = new seguimientos();

        if ($request->hasFile('file')) {
            $doc['file'] = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('correspondencia',$doc['file']);
        }

        $doc->estatus = $request->estatus;
        // $doc->bandeja_de = $request->bandeja_de;
        $doc->accion = $request->accion;
        // $doc->seguimiento = $request->seguimiento;
        $seg->tipo_c = 0;
        $seg->estatus = $request->estatus;
        $seg->accion = $request->accion;
        $seg->bandeja_de = $request->bandeja_de;
        $seg->id_usuario = Auth::id();
        $seg->id_documento = $id_doc;
        $seg->fecha = date("Y/m/d");
        // $seg->seguimiento = $request->seguimiento;
        //$doc->file = $request->file;
        if ($request->instruccion != null) {
            $doc->referencia = $request->instruccion;
            $seg->instruccion = $request->instruccion;
        }else{
            $seg->instruccion = $doc->referencia;
        }
        $doc->save();
        $seg->save();
        return back();
    }
    public function add_enviado(Request $request)
    {
        $env = enviados::orderBy('id', 'desc')->first();
        $enviado = new enviados();

        $enviado['uuid'] = (string) Str::uuid();
        if ($request->hasFile('file')) {
            $enviado['file'] = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('correspondencia',$enviado['file']);
        }

        $enviado->fecha_doc = $request->fecha_doc;
        $enviado->referencia = $request->referencia;
        $enviado->tipo = $request->tipo;
        $enviado->destinatario = $request->destinatario;
        $enviado->otro = $request->otro;
        $enviado->estatus = $request->estatus;
        $enviado->fecha_rec = $request->fecha_rec;
        if ($request->ccopia_a = "SI") {
            $enviado->ccopia = $request->ccopia;
        }
        
        if ($request->tipo_doc == "OFICIO") {
            $enviado->nro_doc = $request->nro_doc . ' ' . $request->nro;
        }else{
            $enviado->nro_doc = $request->nro_c;
        }
        
        $enviado->tipo_doc = $request->tipo_doc;
        $enviado->recibido_por = Auth::id();
        $enviado->accion = $request->accion;
        $enviado->bandeja_de = $request->bandeja_de;
        $enviado->seguimiento = $request->seguimiento;
        $enviado->tipo_c = 1;

        $tipo_c = $request->tipo;
        if ($tipo_c == 1) {
            $enviado-> tipo = 'INTERNA';
        }elseif ($tipo_c == 2){
            $enviado-> tipo = 'EXTERNA';
        }
        if($env){
            $id = $env->id + 1;
            $enviado->codigo = 'DOC-EN' . str_pad($id, 3, '0', STR_PAD_LEFT) . '-21';
        }else{
            $id = 1;
            $enviado->codigo = 'DOC-EN' . str_pad($id, 3, '0', STR_PAD_LEFT) . '-21';
        }
        $ref = $request->ref_doc;
        if ($ref != null) {
            $enviado->ref_doc = $ref;
        }
        $lim =$request->fecha_lim;
        if ($lim != null) {
            $enviado->fecha_lim = $lim;
        }
        if ($request->tipo == 'EXTERNA'){
            $enviado->estado = $request->estado;
        }

        // $enviado->id_user = Auth::id();
        // $enviado->id_user_destino = Auth::id();
        $enviado -> save();

        $seg = new seguimientos();
        if($env){
            $id = $env->id + 1;
            $seg->id_documento = $id;
        }else{
            $id = 1;
            $seg->id_documento = $id;
        }
        $seg->id_usuario = Auth::id();
        $seg->tipo_c = 1;
        $seg->accion = $request->accion;
        $seg->fecha = date("Y/m/d");
        $seg->bandeja_de = $request->bandeja_de;
        $seg->instruccion = $request->referencia;
        $seg->estatus = $request->estatus;
        $seg-> save();

        return back();
        
    }
    public function add_recibido(Request $request)
    {
        $rec= recibidos::orderBy('id', 'desc')
                      ->first();
        $recibido = new recibidos();
        $recibido['uuid'] = (string) Str::uuid();
        if ($request->hasFile('file')) {
            $recibido['file'] = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('correspondencia',$recibido['file']);
        }
        $recibido-> fecha_doc = $request->fecha_doc;
        $recibido-> referencia = $request->referencia;
        $recibido-> remitente = $request->remitente;
        if ($request->tipo = 'EXTERNA'){
            $recibido-> estado = $request->estado;
        }
        $recibido-> otro = $request->otro;
        $recibido-> estatus = $request->estatus;
        $recibido-> tipo_c = 0;
        $recibido-> nro_doc = $request->nro_doc;
        $recibido-> tipo_doc = $request->tipo_doc;
        $recibido-> recibido_por = Auth::id();
        $recibido-> accion = $request->accion;
        $recibido-> seguimiento = $request->seguimiento;
        $recibido-> bandeja_de = $request->bandeja_de;
        $tipo_c = $request->tipo;
        if ($tipo_c == 1) {
            $recibido-> tipo = 'INTERNA';
        }elseif ($tipo_c == 2){
            $recibido-> tipo = 'EXTERNA';
        }
        if($rec){
            $id = $rec->id + 1;
            $recibido->codigo = 'DOC-RE' . str_pad($id, 3, '0', STR_PAD_LEFT) . '-21';
        }else{
            $id = 1;
            $recibido->codigo = 'DOC-RE' . str_pad($id, 3, '0', STR_PAD_LEFT) . '-21';
        }
        if ($request->ref_doc) {
            $recibido->ref_doc = $request->ref_doc;
        }
        if ($request->fecha_lim) {
            $recibido->fecha_lim = $request->fecha_lim;
        }

        $recibido -> save();

        $seg = new seguimientos();
        if($rec){
            $id = $rec->id + 1;
            $seg->id_documento = $id;
        }else{
            $id = 1;
            $seg->id_documento = $id;
        }
        $seg->id_usuario = Auth::id();
        $seg->tipo_c = 0;
        $seg->accion = $request->accion;
        $seg->fecha = date("Y/m/d");
        $seg->bandeja_de = $request->bandeja_de;
        $seg->instruccion = $request->referencia;
        $seg->estatus = $request->estatus;
        $seg-> save();

        return back();
    }
    public function get_users()
    {
        $usuarios = User::get();
        return $usuarios;
    }
    public function get_estados()
    {
        $estadoss = estados::get();
        return $estadoss;
    }
    public function get_externos()
    {
        $entes = EntesExternos::get();
        return $entes;
    }
    public function get_internos()
    {
        $entes = EntesInternos::get();
        return $entes;
    }
    public function download_env($uuid)
    {
        $archivo = enviados::where('uuid', $uuid)->firstOrFail();
        $pathFile = storage_path("app/correspondencia/".$archivo->file);
        return response()->download($pathFile);
    }
    public function download_res($uuid)
    {
        $archivo = recibidos::where('uuid', $uuid)->firstOrFail();
        $pathFile = storage_path("app/correspondencia/".$archivo->file);
        return response()->download($pathFile);
    }
    public function print_env($id)
    {
        $id_doc = decrypt($id);
        $doc = enviados::find($id_doc);
        $seg = seguimientos::get();
        $users = User::get();
        return view('user/print', compact('doc','seg','users'));
    }
    public function print_rec($id)
    {
        $id_doc = decrypt($id);
        $doc = recibidos::find($id_doc);
        $seg = seguimientos::get();
        $users = User::get();
        return view('user/print', compact('doc','seg','users'));
    }
}
