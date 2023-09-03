<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;
use App\Models\Project;
use App\Models\ProjectHistory;
use App\Models\Team;

class ProjectController extends Controller
{
    public function add(Request $request)
    {
      $project_name=$request->input("project_name");
      $project_info=$request->input("project_info");
      
      Project::create([
        "project_name"=>$project_name,
        "project_info"=>$project_info,
        "project_status"=>null
      ]);
      
      $response=new Response(null,200);
      return ResponseStatus::set_status($response,"project-create-success");
    }
    
    public function assign(Request $request,$project_id)
    {
      /*
      Assign a project to a team
      */
      $team_id=$request->input("team_id");
      
      Team::where("team_id",$team_id)->update([
        "project_id"=>$project_id
        ]);
     $response=new Response(null,200);
     return ResponseStatus::set_status($response,"project-assign-success");
      
    }
    
    public function add_log(Request $request,$team_id,$project_id)
    {
      
      $progress_info=$request->input("progress_info");
      $extra=$request->input("extra");
      $project_manager_id=$request->user()->id;
      
      ProjectHistory::create([
        "project_id"=>$project_id,
        "team_id"=>$team_id,
        "project_manager_id"=>$project_manager_id,
        "progress_info"=>$progress_info,
        "extra"=>$extra
        ]);
      
      $response=new Response(null,200);
      return ResponseStatus::set_status($response,"project-log-stored");
    }
    
}
