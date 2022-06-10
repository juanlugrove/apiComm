<?php

namespace App\Http\Controllers;

use App\Models\Usersearchteam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersearchteamController extends Controller
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
        $userST=Usersearchteam::all();
        return $userST;
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
            'date' => 'required',
            'description' => 'required|max:100',
        ]);
        
        if(Usersearchteam::where('idUser', Auth::user()->idUser)->count()>0){
            return response()->json(['error' => 'You are already searching a team'], 401);
            
        } else {
                $userST=new Usersearchteam();
                $userST->idUser=Auth::user()->idUser;
                $userST->date=$request->date;
                $userST->description=$request->description;
                if(isset($request->video)){
                    $userST->video=$request->video;
                }
                $userST->save();
    
                return \response($userST);
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
        return Usersearchteam::find($id);
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
    public function destroy()
    {
        if(Usersearchteam::where('idUser', Auth::user()->idUser)->count()>0){
            $userST= Usersearchteam::where("idUser", Auth::user()->idUser)->delete();
            return response()->json(['message' => 'Successfully deleted'], 200);
        } else {
            return response()->json(['error' => 'You are not looking for a team yet'], 401);
        }
    }
}
