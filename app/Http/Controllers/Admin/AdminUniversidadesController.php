<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Universidad;

use Illuminate\Support\Facades\Session;

class AdminUniversidadesController extends Controller
{
    protected $pageName = "Universidades";
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
    public function index($order_field='nombre', $order_direction='asc')
    {

        $unis = Universidad::orderBy($order_field, $order_direction)->paginate(config('admin.pagination'));


        return view('admin/admin_universidades')->with(["universidades" => $unis])->with(['pageName'=>$this->pageName])->with(['order_field'=>$order_field, 'order_direction'=>$order_direction]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin/admin_universidades_add')->with(['pageName'=>"Nuevo"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //Hash::make($request_data['password']); 

        $this->validate($request, ['nombre' => 'required|max:255', 'nombre_corto' => 'required|max:255']);

        $slug = str_slug($request->nombre);


        if(Universidad::where("slug", "=", $slug)->count()>0){

            $i=1;

            while(true){

                 if(Universidad::where("slug", "=", $slug."-".$i)->count()==0){
                    $slug = $slug."-".$i;
                    break;
                 }
                 $i++;

            }

        }

        $universidad = new Universidad();
        $universidad = $universidad->create([
        'nombre' => $request->nombre,
        'nombre_corto' => $request->nombre_corto,
        'slug' => $slug,
        ]);


        return redirect('/admin/universidades');
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
       $universidad = Universidad::findOrFail($id);


        return view('admin/admin_universidades_edit')->with(['pageName'=>"Edita"])->with(['universidad'=>$universidad]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {

        $universidad = Universidad::findOrFail($id);

        $this->validate($request, [
            'nombre' => 'required',
            'nombre_corto' => 'required',
            'slug' => 'required',
        ]);

        $slug = $request->slug;

        if(Universidad::where("slug", "=", $slug)->where("id", "<>", $id)->count()>0){

            $i=1;

            while(true){

                 if(Universidad::where("slug", "=", $slug."-".$i)->count()==0){
                    $slug = $slug."-".$i;
                    break;
                 }
                 $i++;

            }

        }


        $universidad->fill([
        'nombre' => $request->nombre,
        'nombre_corto' => $request->nombre_corto,
        'slug' => $slug,
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
        $universidad = Universidad::findOrFail($id);

        $universidad->delete();

        Session::flash('flash_message', 'Universidad eliminada.');

        return redirect()->route('universidades.index');
    }
}
