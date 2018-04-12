<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Apunte;
use App\Curso;
use App\Archivo;
use App\ApunteReaccion;
use App\Universidad;

use CloudConvert\Api;

use Helper;

class ApuntesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    
        $user = auth()->user();

        $apuntes = Apunte::join('cursos', 'cursos.id', '=', 'apuntes.curso_id')->where("cursos.universidad_id", "=", $user->universidad_id)->select('apuntes.*', 'cursos.nombre as curso_nombre', 'cursos.universidad_id')->orderBy("created_at", "desc")->get();

        

        return view('apuntes')->with(["apuntes" => $apuntes]);
    }  
    public function listJson()
    {
    
        $user = auth()->user();


        $apuntes = Apunte::where("universidad_id", "=", $user->universidad_id)->orderBy("created_at", "desc")->get();

        return response()->json( $apuntes, 201);
    }  

    public function getBySlugJson($slug)
    {
    
        $apunte = Apunte::where("slug", "=", $slug)->first();

        return response()->json( $apunte, 201);
    }  

    public function getDocentesJson($id)
    {
    
        $docentes = Apunte::select("docente")->where("universidad_id", "=", $id)->distinct("docente")->orderBy("docente", "asc")->get();

        return response()->json( $docentes, 201);
    }  


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($slug)
    {


        $user = auth()->user();

        $apunte = Apunte::where('slug', '=', $slug)->first();

        $comentarios = $apunte->comentarios()->orderBy("created_at", "desc")->get();

        $archivos = $apunte->archivos()->get();

        return view('apuntes_show')->with(["apunte" => $apunte])->with(["archivos"=>$archivos]);
    }

    public function listado()
    {

        $user = auth()->user();

        $apuntes = Apunte::where("user_id", "=", $user->id)->orderBy("created_at", "desc")->get();

        return view('mis-apuntes')->with(["apuntes" => $apuntes]);
    }  

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cursos = Curso::orderBy("nombre", "asc")->get();

        return view('mis-apuntes_add')->with(["cursos"=>$cursos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function storeJson(Request $request)
    {
     
        $user = auth()->user();


        $this->validate($request, ['nombre' => 'required|max:255', 'curso_id' => 'required', 'docente' => 'required', 'ciclo' => 'required', 'tipo' => 'required', 'descripcion' => 'required']);
     

        $curso = Curso::findOrFail($request->curso_id);

        $universidad = Universidad::findOrFail($curso->universidad_id);

        $slug = str_slug($request->nombre) . '-' . $universidad->slug;


        if(Apunte::where("slug", "=", $slug)->count()>0){

            $i=1;

            while(true){

                 if(Apunte::where("slug", "=", $slug."-".$i)->count()==0){
                    $slug = str_slug($request->nombre) . '-' . $universidad->slug."-".$i;
                    break;
                 }
                 $i++;

            }

        }

        $imagenes = [];

        $archivos = 0;
  
        if(!empty($request->file('imagen'))){

            if($request->hasFile('imagen')){

                $imagenes = $request->file('imagen');
                $archivos = count($imagenes);
            }

        }
 
        if(!empty($request->file('archivo'))){

            if($request->hasFile('archivo'))
            {

                $archivos = 1;

            }
        }
     

        $apunte = new Apunte();
        $apunte = $apunte->create([
        'nombre' => $request->nombre,
        'slug' => $slug,
        'curso_id' => $request->curso_id,
        'universidad_id' => $universidad->id,
        'user_id' => $user->id,
        'docente' => $request->docente,
        'ciclo' => $request->ciclo,
        'tipo' => $request->tipo,
        'descripcion' => $request->descripcion,
        'archivos' => $archivos,
        ]);

  
                
        $i = 1;
        foreach ($imagenes as $imagen) {

            $base = $user->id.'_'.$i.time();

            $ext = $imagen->getClientOriginalExtension();

            $input['filename'] = $base.'.'.$ext;

            $destinationPath = storage_path('archivos');

            $imagen->move($destinationPath, $input['filename']);

            $mime=File::mimeType($destinationPath.DIRECTORY_SEPARATOR .$input['filename']);
                
            $imagen = new Archivo();
            $imagen = $imagen->create([
                    'apunte_id' => $apunte->id,
                    'tipo' => $mime,
                    'nombre' => $input['filename'],
             ]);

            if(i==1){


                $apunte->fill([
                'thumbnail' => $input['filename']
                ])->save();
            }

            $i++;

        }
         


      
        if(!empty($request->file('archivo'))){

            $archivo = $request->file('archivo');

            if($request->hasFile('archivo'))
            {
                
                $base = $user->id.'_'.time();

                $ext = $archivo->getClientOriginalExtension();

                $input['filename'] = $base.'.'.$ext;

                $destinationPath = storage_path('archivos');

                $archivo->move($destinationPath, $input['filename']);

                $mime=File::mimeType($destinationPath.DIRECTORY_SEPARATOR .$input['filename']);
                    
                $archivo = new Archivo();
                $archivo = $archivo->create([
                        'apunte_id' => $apunte->id,
                        'tipo' => $mime,
                        'nombre' => $input['filename'],
                 ]);


                if(strpos($mime, "image")===false){

                    Helper::toPdf($archivo);

                }


                Helper::toThumbnail($archivo);
                 
            }



        }
        return response()->json($apunte, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {


        $user = auth()->user();

        $this->validate($request, ['nombre' => 'required|max:255', 'curso_id' => 'required', 'docente' => 'required', 'ciclo' => 'required', 'tipo' => 'required', 'descripcion' => 'required']);


        $curso = Curso::findOrFail($request->curso_id);

        $universidad = Universidad::findOrFail($curso->universidad_id);

        $slug = str_slug($request->nombre) . '-' . $universidad->slug;


        if(Apunte::where("slug", "=", $slug)->count()>0){


            $i=1;

            while(true){

                 if(Apunte::where("slug", "=", $slug."-".$i)->count()==0){
                    $slug = str_slug($request->nombre) . '-' . $universidad->slug."-".$i;
                    break;
                 }
                 $i++;

            }

        }

        $imagenes = [];

        $archivos = 0;
  
        if(!empty($request->file('imagen'))){

            if($request->hasFile('imagen')){

                $imagenes = $request->file('imagen');
                $archivos = count($imagenes);
            }

        }
 
        if(!empty($request->file('archivo'))){

            if($request->hasFile('archivo'))
            {

                $archivos = 1;

            }
        }
     

        $apunte = new Apunte();
        $apunte = $apunte->create([
        'nombre' => $request->nombre,
        'slug' => $slug,
        'curso_id' => $request->curso_id,
        'universidad_id' => $user->universidad_id,
        'user_id' => $user->id,
        'docente' => $request->docente,
        'ciclo' => $request->ciclo,
        'tipo' => $request->tipo,
        'descripcion' => $request->descripcion,
        'archivos' => $archivos,
        ]);

  
                
        $i = 1;
        foreach ($imagenes as $imagen) {

            $base = $user->id.'_'.$i.time();

            $ext = $imagen->getClientOriginalExtension();

            $input['filename'] = $base.'.'.$ext;

            $destinationPath = storage_path('archivos');

            $imagen->move($destinationPath, $input['filename']);

            $mime=File::mimeType($destinationPath.DIRECTORY_SEPARATOR .$input['filename']);
                
            $imagen = new Archivo();
            $imagen = $imagen->create([
                    'apunte_id' => $apunte->id,
                    'tipo' => $mime,
                    'nombre' => $input['filename'],
             ]);

            if(i==1){


                $apunte->fill([
                'thumbnail' => $input['filename']
                ])->save();
            }

            $i++;

        }
         


      
        if(!empty($request->file('archivo'))){

            $archivo = $request->file('archivo');

            if($request->hasFile('archivo'))
            {
                
                $base = $user->id.'_'.time();

                $ext = $archivo->getClientOriginalExtension();

                $input['filename'] = $base.'.'.$ext;

                $destinationPath = storage_path('archivos');

                $archivo->move($destinationPath, $input['filename']);

                $mime=File::mimeType($destinationPath.DIRECTORY_SEPARATOR .$input['filename']);
                    
                $archivo = new Archivo();
                $archivo = $archivo->create([
                        'apunte_id' => $apunte->id,
                        'tipo' => $mime,
                        'nombre' => $input['filename'],
                 ]);


                if(strpos($mime, "image")===false){

                    Helper::toPdf($archivo);

                }


                Helper::toThumbnail($archivo);
                 
            }



        }
        return redirect('/mis-apuntes');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $apunte = Apunte::findOrFail($id);

        $user = auth()->user();

        //Si no corresponde al usuario
        if($apunte->user_id!=$user->id){
            return redirect()->back();
        }

        $archivos = $apunte->archivos()->get();

        $cursos = Curso::orderBy("nombre", "asc")->get();

        $token = str_random(16);
        session(['token' => $token]);

        return view('mis-apuntes_edit')->with(['pageName'=>"Edita"])->with(['apunte'=>$apunte])->with(['cursos'=>$cursos])->with(['archivos'=>$archivos])->with(['token'=>$token]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {

        $apunte = Apunte::findOrFail($id);

        $user = auth()->user();

        //Si no corresponde al usuario
        if($apunte->user_id!=$user->id){
            return redirect()->back();
        }

        $this->validate($request, [
            'nombre' => 'required', 
            'curso_id' => 'required',
            'descripcion' => 'required',
            'docente' => 'required',
            'ciclo' => 'required',
        ]);


        $input = $request->all();

        $apunte->fill($input)->save();




        Session::flash('flash_message', 'Cambios Guardados');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $apunte = Apunte::findOrFail($id);

        $user = auth()->user();
        //Si no corresponde al usuario
        if($apunte->user_id!=$user->id){
            return redirect()->back();
        }

        $apunte->delete();


        Session::flash('flash_message', 'Apunte eliminado.');

        return redirect()->route('misapuntes.index');
    }  



    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function react($apunte_id, Request $request)
    {

        $apunte = Apunte::findOrFail($apunte_id);

        $user = auth()->user();

        $this->validate($request, [ 'tipo' => 'required']);


        $reaccion = $apunte->reacciones()->where('user_id', '=', $user->id)->first();

        if(empty($reaccion)){

            $reaccion = new ApunteReaccion();
            $reaccion = $reaccion->create([
            'apunte_id' => $apunte_id,
            'user_id' => $user->id,
            'tipo' => $request->tipo,
            ]);

        }else if($reaccion->tipo!=$request->tipo){

            $tipo = ["tipo" => $request->tipo];
            $reaccion->fill($tipo)->save();

        }else{

            $reaccion->delete();

        }

        $pos = $apunte->reacciones()->where('tipo', '=', 1)->count();
        $neg = $apunte->reacciones()->where('tipo', '=', 0)->count();

        $apunte->fill(["positivos"=>$pos, "negativos"=>$neg])->save();

        return response()->json(['data' => $apunte], 201);
    }


}
