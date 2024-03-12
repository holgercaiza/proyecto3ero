<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use DB;
use Auth;
use Session;


class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios=User::where('usr_id','<>',3)->orderBy('usr_usuario')->get();//No SuperAdmin
        return view('usuarios.index')
        ->with('usuarios',$usuarios)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->all();
        $input['password']=bcrypt('123456');
        User::create($input);
        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $usuario=User::find($id);
        return view('usuarios.show')
        ->with('usuario',$usuario);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $usuario=User::find($id);
        return view('usuarios.edit')
        ->with('usuario',$usuario)
        ;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $input=($request->all());
        $usuario=User::find($id);
        if (!$usuario) {
            return redirect()->back()->withErrors('Usuario no encontrado');
        }
        if(isset($input['bn_save_key'])){
            $input['password']=bcrypt($input['password']);
        }
        $usuario->fill($input);
        $usuario->save();
        return redirect()->route('usuarios.index');        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('usuarios.index');        
    }

    public function profile($id){

        $usuario=User::find($id);
        return view('usuarios.show')
        ->with('usuario',$usuario);

    }




}
