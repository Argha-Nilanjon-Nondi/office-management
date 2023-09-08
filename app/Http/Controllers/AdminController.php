<?php

namespace App\Http\Controllers;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;

class AdminController extends Controller
{

  public function object_history_log(Request $request,$object_id) {
    $history=Audit::where("auditable_id",$object_id)
             ->simplePaginate(5);
    $response = new Response($history, 200);
    return ResponseStatus::set_status($response, "object-history-list");
  }

}