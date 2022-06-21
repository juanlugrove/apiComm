<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Teamuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamuserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teamUsers = Teamuser::all();
        return $teamUsers;
    }
    public function usersTeam($teamId)
    {
        $teamUsers = Teamuser::where('idTeam',$teamId)->get();
        return $teamUsers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'idTeam' => 'required',
            'idUser' => 'required|unique:teamusers'
        ]);

        if(Auth::user()->idUser==Team::findOrFail($request->idTeam)->captain){
            $teamUser = new Teamuser();
            $teamUser->idTeam=$request->idTeam;
            $teamUser->idUser=$request->idUser;
            $teamUser->save();
            return \response($teamUser);
        }
        
        return response()->json(['error' => 'Unauthorized'], 401);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function salir(){
        $teamUser=Teamuser::where("idUser",Auth::user()->idUser);
        if(Team::find($teamUser->first()->idTeam)->captain!=Auth::user()->idUser){
            $prueba= $teamUser->delete();
            return \response($prueba);
        } else if(count(Teamuser::where("idTeam",$teamUser->first()->idTeam)->get())>1){
            
            return response()->json(['error' => 'You are the captain'], 401);
        } else {
            $idTeam=$teamUser->first()->idTeam;
            $prueba= $teamUser->delete();
            Team::find($idTeam)->delete();
            return \response($idTeam);
        }
    }

    public function destroy($id)
    {
        $teamUser = Teamuser::where("idUser",$id)->first();

        if(Auth::user()->idUser==Team::find($teamUser->idTeam)->captain && Team::find($teamUser->idTeam)->captain!=$id){
            // $teamUser->delete();
            $prueba= Teamuser::where("idUser",$id)->delete();
            
            return \response($prueba);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
