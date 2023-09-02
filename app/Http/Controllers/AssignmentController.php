<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;
use App\Models\ProjectAssignment;

class AssignmentController extends Controller
{

  public function add(Request $request) {
    $team_id = $request->input("team_id");
    $project_id = $request->input("project_id");
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
}