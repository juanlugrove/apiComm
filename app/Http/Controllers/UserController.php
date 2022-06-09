<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $usuarios = User::all();
        return $usuarios;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    public function store(Request $request)

    {
        $request->validate([
            'username' => 'required',
            'mail' => 'required',
            'password' => 'required',
            'platform' => 'required'
        ]);
        $usuario = new User();
        $usuario->username = $request->username;
        $usuario->mail = $request->mail;
        $usuario->password = $request->password;
        $usuario->platform = $request->platform;

        // $usuario = $request;
        
        $usuario->save();

        return \response($usuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
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

        $usuarioLogueado = Auth::user();
        if($id==$usuarioLogueado->idUser){
            $usuario = User::findOrFail($id)->update($request->all());
            return \response($usuario);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        if(Auth::user()->idUser==$usuario->idUser){
            $usuario=User::destroy($id);
            return \response($usuario);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
