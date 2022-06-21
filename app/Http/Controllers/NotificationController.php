<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Team;
use App\Models\Teamsearchuser;
use App\Models\Teamuser;
use App\Models\User;
use App\Models\Usersearchteam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
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
        $notis=Notification::where('idUser', Auth::user()->idUser)->get();
        $notisEnviar=[];
            foreach ($notis as $noti) {
                $noti->setAttribute("username",User::find($noti->sendBy)->username);
                if($noti->type=='team'){
                    $noti->setAttribute("teamName",Team::where('captain',$noti->sendBy)->first()->name);
                } else if($noti->type=='user'){
                    $noti->setAttribute("twitter",User::find($noti->sendBy)->twitter);
                }
                $notisEnviar[]=$noti;
            }
        return $notisEnviar;
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
            'idUser' => 'required',
            'type' => 'required',
            'idPostulacion' => 'required'
        ]);

        $noti= new Notification();
        $noti->idUser=$request->idUser;
        $noti->type=$request->type;
        $noti->idPostulacion=$request->idPostulacion;
        $noti->sendBy=Auth::user()->idUser;
        if(Auth::user()->idUser!=$request->idUser){
            if(Notification::where("idPostulacion",$request->idPostulacion)->where("sendBy",Auth::user()->idUser)->count()>0){
                return response()->json(['error' => 'You are already postulated'], 401);
            }
            if($noti->type=="user"){
                if(Teamuser::where("idUser",Auth::user()->idUser)->count()>0){
                    return response()->json(['error' => 'You are already in a team'], 401);
                }
                $noti->save();
                return response()->json(['message' => 'Successfully created'], 200);
            }
            if(Team::where("captain",Auth::user()->idUser)->count()==0){
                return response()->json(['error' => 'You are not the captain'], 401);
            }
            $noti->save();
            return response()->json(['message' => 'Successfully created'], 200);
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

    public function acceptNotification($idNoti){
        $noti=Notification::find($idNoti);
        if($noti->idUser==Auth::user()->idUser){
            if($noti->type=="user"){
                $teamUser = new Teamuser();
                $teamUser->idTeam=Team::where("captain",Auth::user()->idUser)->first()->idTeam;
                $teamUser->idUser=$noti->sendBy;
                $teamUser->save();
                Usersearchteam::where("idUser",$noti->sendBy)->delete();
                Teamsearchuser::find($noti->idPostulacion)->delete();
                Notification::where("idUser",$noti->sendBy)->delete();
                Notification::where("sendBy",$noti->sendBy)->delete();
                return response()->json(['message' => 'Successfully accepted'], 200);
            } else if($noti->type=="team"){
                $teamUser = new Teamuser();
                $teamUser->idTeam=Team::where("captain",$noti->sendBy)->first()->idTeam;
                $teamUser->idUser=Auth::user()->idUser;
                $teamUser->save();
                Usersearchteam::where("idUser",Auth::user()->idUser)->delete();
                Notification::where("idUser",Auth::user()->idUser)->delete();
                Notification::where("sendBy",Auth::user()->idUser)->delete();
                return response()->json(['message' => 'Successfully accepted'], 200);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function declineNotification($idNoti){
        $noti=Notification::find($idNoti);
        if($noti->idUser==Auth::user()->idUser){
            Notification::destroy($idNoti);
            return response()->json(['message' => 'Successfully deleted'], 200);
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
        //
    }
}
