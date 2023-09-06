<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;
use App\Models\ProjectAssignment;

class EmployeeController extends Controller
{
    public function assignment_list(Request $request)
    {
      $worker_id=$request->user()->id;
      $assignments=ProjectAssignment::where("worker_id",$worker_id)
                 ->select("assignment_id","assignment_name")
                 ->orderByDesc("updated_at")
                 ->simplePaginate(10);
      $response=new Response($assignments,200);
      return ResponseStatus::set_status($response,"assignment-list");

    }
    
    public function single_assignment(Request $request,$assignment_id)
    {
      $worker_id=$request->user()->id;
    $assignment=ProjectAssignment::where(["worker_id"=>$worker_id,"assignment_id"=>$assignment_id])->first();
    $response=new Response($assignment,200);
    return ResponseStatus::set_status($response,"single-assignment");

    }
    
}
