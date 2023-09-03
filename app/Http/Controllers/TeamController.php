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
    
    public function assign(Request $request,$team_id)
    {
      /*
      Assign user to a team
      */
      $user_id=$request->input("user_id");
      
      TeamMember::create([
        "team_id"=>$team_id,
        "user_id"=>$user_id
        ]);
      
      $response=new Response(null,200);
      return ResponseStatus::set_status($response,"user-assign-success");
    }
    
    public function team_list(Request $request){
      $team=Team::select("team_id","team_name")
                 ->orderByDesc("updated_at")
                 ->simplePaginate(10);
      $response=new Response($team,200);
      return ResponseStatus::set_status($response,"team-list");
    }
    
    public function single_team(Request $request,$team_id){
      $single_team=Team::where("team_id",$team_id)->first();
      $team_member=TeamMember::where("team_id",$team_id)
                             ->select("user_id")
                             ->get();
      $single_team["team_members"]=$team_member;
      $response=new Response($single_team,200);
      return ResponseStatus::set_status($response,"single-team");
    }
}
