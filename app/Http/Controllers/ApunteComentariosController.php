<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApunteComentario;
use App\ApunteComentarioReaccion;

class ApunteComentariosController extends Controller
{
    public function index($apunte_id)
    {

        $comentarios = ApunteComentario::select("apunte_comentarios.id","texto", "apunte_comentarios.user_id","positivos","negativos")->leftJoin("apunte_comentarios_reacciones", "apunte_comentarios_reacciones.apunte_comentario_id", "=", "apunte_comentarios.id")->where("apunte_id", "=", $apunte_id)->orderBy("apunte_comentarios.created_at", "desc")->get();


         return response()->json(['data' => $comentarios], 201);
    }  


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($apunte_id, Request $request)
    {


        $user = auth()->user();

        $this->validate($request, ['texto' => 'required']);
     
        $comentario = new ApunteComentario();
        $comentario = $comentario->create([
        'texto' => $request->texto,
        'user_id' => $user->id,
        'apunte_id' => $apunte_id,
        ]);


         return response()->json(['data' => $comentario], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $comentario = ApunteComentario::findOrFail($id);

        $user = auth()->user();
        //Si no corresponde al usuario
        if($comentario->user_id!=$user->id){
           // return redirect()->back();
         	return response()->json(['data' => '', 'error' => 'petición rechazada'], 201);
        }

        $comentario->delete();

         return response()->json(['data' => $comentario], 201);
    }  

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function react($comentario_id, Request $request)
    {

        $comentario = ApunteComentario::findOrFail($comentario_id);

        $user = auth()->user();

        $this->validate($request, [ 'tipo' => 'required']);


        $reaccion = $comentario->reacciones()->where('user_id', '=', $user->id)->first();

        if(empty($reaccion)){

            $reaccion = new ApunteComentarioReaccion();
            $reaccion = $reaccion->create([
            'apunte_comentario_id' => $comentario_id,
            'user_id' => $user->id,
            'tipo' => $request->tipo,
            ]);

        }else if($reaccion->tipo!=$request->tipo){

            $tipo = ["tipo" => $request->tipo];
            $reaccion->fill($tipo)->save();

        }else{

            $reaccion->delete();

        }

        $pos = $comentario->reacciones()->where('tipo', '=', 1)->count();
        $neg = $comentario->reacciones()->where('apunte_comentario_id', '=', $comentario_id)->where('tipo', '=', 0)->count();

        $comentario->fill(["positivos"=>$pos, "negativos"=>$neg])->save();

        return response()->json(['data' => $comentario], 201);
    }


}
