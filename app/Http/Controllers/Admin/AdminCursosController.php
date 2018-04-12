<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Curso;
use App\Universidad;

use Illuminate\Support\Facades\Session;

class AdminCursosController extends Controller
{
    protected $pageName = "Cursos";
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
    public function index($universidad_id='', $order_field='nombre', $order_direction='asc')
    {

       $universidades = Universidad::orderBy("nombre", "asc")->get();

       if($universidad_id==''){

            $universidad_id = $universidades[0]->id;

       }

       $cursos = Curso::where("universidad_id", "=", $universidad_id)->orderBy($order_field, $order_direction)->paginate(config('admin.pagination'));


        return view('admin/admin_cursos')->with(["cursos" => $cursos])->with(['pageName'=>$this->pageName])->with(['order_field'=>$order_field, 'order_direction'=>$order_direction])->with(["universidades"=>$universidades])->with(["universidad_id"=>$universidad_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
       $universidades = Universidad::orderBy("nombre", "asc")->get();
        return view('admin/admin_cursos_add')->with(['pageName'=>"Nuevo"])->with(["universidades"=>$universidades]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['nombre' => 'required|max:255', 'universidad_id' => 'required']);

        $slug = str_slug($request->nombre);

        if(Curso::where("slug", "=", $slug)->count()>0){

            $i=1;

            while(true){

                 if(Curso::where("slug", "=", $slug."-".$i)->count()==0){
                    $slug = $slug."-".$i;
                    break;
                 }
                 $i++;

            }

        }

        $curso = new Curso();
        $curso = $curso->create([
        'nombre' => $request->nombre,
        'slug' => $slug,
        'universidad_id' => $request->universidad_id,
        ]);


        return redirect('/admin/cursos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
       $curso = Curso::findOrFail($id);


       $universidades= Universidad::orderBy("nombre", "asc")->get();
        return view('admin/admin_cursos_edit')->with(['pageName'=>"Edita"])->with(['curso'=>$curso])->with(['universidades'=>$universidades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {

        $curso = Curso::findOrFail($id);

        $this->validate($request, [
            'nombre' => 'required',
            'slug' => 'required', 
            'universidad_id' => 'required',
        ]);

        $slug = $request->slug;

        if(Curso::where("slug", "=", $slug)->where("id", "<>", $id)->count()>0){

            $i=1;

            while(true){

                 if(Curso::where("slug", "=", $slug."-".$i)->count()==0){
                    $slug = $slug."-".$i;
                    break;
                 }
                 $i++;

            }

        }


        $input = $request->all();

        $curso->fill([
        'nombre' => $request->nombre,
        'slug' => $slug,
        'universidad_id' => $request->universidad_id,
        ])->save();

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
        $curso = Curso::findOrFail($id);


        $curso->delete();


        Session::flash('flash_message', 'Curso eliminado.');

        return redirect()->route('cursos.index');
    }
}
