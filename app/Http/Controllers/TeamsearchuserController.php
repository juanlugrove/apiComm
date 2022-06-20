<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Teamsearchuser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamsearchuserController extends Controller
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
        $teamSU = Teamsearchuser::orderBy('date', 'ASC')->get();
        $teamSUconNombre=[];
        foreach ($teamSU as $team) {
            $equipo=Team::find($team->idTeam);
            $team->setAttribute("nameTeam",$equipo->name);
            $capi=User::find($equipo->captain);
            $team->setAttribute("nameCaptain",$capi->username);
            $teamSUconNombre[]=$team;
        }
        return $teamSUconNombre;
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
            'description' => 'required|max:100',
            'position' => 'required|max:10'
        ]);

        if(Team::where("captain",Auth::user()->idUser)->count()>0){
            $team=Team::where("captain",Auth::user()->idUser)->first();
            if(Teamsearchuser::where("idTeam",$team->idTeam)->count()>=5){
                return response()->json(['error' => "You have searching 5 players, please delete one to continue"], 401);
            } else {
                $teamSU=new Teamsearchuser();
                $teamSU->idTeam=$team->idTeam;
                $teamSU->date=Carbon::now();
                $teamSU->description=$request->description;
                $teamSU->position=$request->position;

                $teamSU->save();

                return response()->json(['message' => 'Successfully created'], 200);
            }
        } else {
            return response()->json(['error' => "You aren't the captain for a team"], 401);
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
        return Teamsearchuser::find($id);
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
    public function destroy($id)
    {
        $teamSU=Teamsearchuser::find($id);
        $team=Team::find($teamSU->idTeam);

        if($team->captain==Auth::user()->idUser){
            Teamsearchuser::destroy($id);
            return response()->json(['message' => 'Successfully deleted'], 200);
        } else {
            return response()->json(['error' => 'You are not the captain'], 401);
        }
    }
}
