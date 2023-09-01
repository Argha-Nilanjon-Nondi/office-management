<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;
use App\Models\Team;
use App\Models\TeamMember;

class TeamController extends Controller
{
    public function add(Request $request)
    {
      /*
      Adding a new team
      */
      $team_name=$request->input("team_name");
      $team_info=$request->input("team_info");
      
      Team::create([
        "team_name"=>$team_name,
        "team_info"=>$team_info
      ]);
      
      $response=new Response(null,200);
      return ResponseStatus::set_status($response,"team-create-success");
    }
    
    public function assign(Request $request)
    {
      /*
      Assign user to a team
      */
      $team_id=$request->input("team_id");
      $user_id=$request->input("user_id");
      
      TeamMember::create([
        "team_id"=>$team_id,
        "user_id"=>$user_id
        ]);
      
      $response=new Response(null,200);
      return ResponseStatus::set_status($response,"user-assign-success");
    }
}
