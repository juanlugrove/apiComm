<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Teamuser;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        return $teams;
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
            'name' => 'required'
        ]);
        $team = new Team();
        $team->name=$request->name;
        $team->captain=Auth::user()->idUser;

        if(Teamuser::where("idUser",$team->captain)->count()==0){
            $team->save();
            $teamUser=new Teamuser();
            $teamUser->idTeam=Team::where('captain',$team->captain)->first()->idTeam;
            $teamUser->idUser=Auth::user()->idUser;
    
            $teamUser->save();
            return \response($team);
        } else {
            return response()->json(['error' => 'You already have a team'], 401);
        }
        

        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);

        return $team;
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
        $team = Team::findOrFail($id);

        $usuarioLogueado = Auth::user();
        if($team->captain==$usuarioLogueado->idUser){

            $team->update($request->all());
            return \response($team);
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
        $team = Team::findOrFail($id);

        if(Auth::user()->idUser==$team->captain){
            $team=Team::destroy($id);
            return \response($team);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
