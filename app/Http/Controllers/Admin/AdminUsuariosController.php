<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Universidad;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class AdminUsuariosController extends Controller
{
    protected $pageName = "Usuarios";
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
    public function index($order_field='users.created_at', $order_direction='desc')
    {

        $users = User::join('universidades', 'universidades.id', '=', 'users.universidad_id')->select('users.*', 'universidades.nombre as unombre')->orderBy($order_field, $order_direction)->paginate(config('admin.pagination'));

        return view('admin/admin_usuarios')->with(["users" => $users])->with(['pageName'=>$this->pageName])->with(['order_field'=>$order_field, 'order_direction'=>$order_direction]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
       $universidades= Universidad::orderBy("nombre", "asc")->get();
        return view('admin/admin_usuarios_add')->with(['pageName'=>"Nuevo"])->with(['universidades'=>$universidades]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //Hash::make($request_data['password']); 

        $this->validate($request, ['nombre' => 'required|max:255','password' => 'required','email' => 'required']);

        if (User::where('email', '=', $request->email)->count() > 0) {
               
            $v = Validator::make([], []);

            $v->getMessageBag()->add('email', 'Correo duplicado');
            return redirect()->back()->withErrors($v)->withInput();
        }

        $user = new User();
        $users = $user->create([
        'nombre' => $request->nombre,
        'password' => Hash::make($request->password),
        'email' => $request->email,
        'universidad_id' => $request->universidad_id,
        ]);


        return redirect('/admin/usuarios');
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
       $user = User::findOrFail($id);

       $universidades= Universidad::orderBy("nombre", "asc")->get();

        return view('admin/admin_usuarios_edit')->withUser($user)->with(['pageName'=>"Edita"])->with(['universidades'=>$universidades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {

        $user = User::findOrFail($id);

        $this->validate($request, [
            'nombre' => 'required',
        ]);

        $universidad = $request->input("universidad_id");

        $input = $request->all();
        if($universidad==0){

            $input = $request->only('nombre', 'email');

        }


        $user->fill($input)->save();

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
        $user = User::findOrFail($id);

        $user->delete();

        Session::flash('flash_message', 'Usuario eliminado.');

        return redirect()->route('usuarios.index');
    }


}
