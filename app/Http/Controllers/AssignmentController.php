<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;
use App\Models\ProjectAssignment;

class AssignmentController extends Controller
{

  public function add(Request $request,$team_id,$project_id) {
    $assigner_id = $request->user()->id;
    $worker_id = $request->input("worker_id");
    $assignment_name = $request->input("assignment_name");
    $assignment_info = $request->input("assignment_info");
    $assignment_status = $request->input("assignment_status");
    $extra = $request->input("extra");

    ProjectAssignment::create([
      "team_id" => $team_id,
      "project_id" => $project_id,
      "assigner_id" => $assigner_id,
      "worker_id" => $worker_id,
      "assignment_name" => $assignment_name,
      "assignment_info" => $assignment_info,
      "assignment_status" => $assignment_status,
      "extra" => $extra
    ]);
    
    $response=new Response(null,200);
    return ResponseStatus::set_status($response,"assignment-create-success");
  }
  
  public function assignment_list(Request $request,$team_id,$project_id)
  {
    $assignments=ProjectAssignment::where(["team_id"=>$team_id,"project_id"=>$project_id])
                 ->select("assignment_id","assignment_name")
                 ->orderByDesc("updated_at")
                 ->simplePaginate(10);
    $response=new Response($assignments,200);
    return ResponseStatus::set_status($response,"assignment-list");
  }
  
  public function single_assignment(Request $request,$assignment_id)
  {
    $assignment=ProjectAssignment::where("assignment_id",$assignment_id)->first();
    $response=new Response($assignment,200);
    return ResponseStatus::set_status($response,"single-assignment");
  }
  
}