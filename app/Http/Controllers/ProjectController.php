<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;
use App\Models\Project;
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
    
    public function assign(Request $request)
    {
      /*
      Assign a project to a team
      */
      $team_id=$request->input("team_id");
      $project_id=$request->input("project_id");
      
      Team::where("team_id",$team_id)->update([
        "project_id"=>$project_id
        ]);
     $response=new Response(null,200);
     return ResponseStatus::set_status($response,"project-assign-success");
      
    }
}
