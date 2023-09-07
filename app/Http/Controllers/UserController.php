<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;
use App\Jobs\QueueEmailPassword;
use App\Models\User;
use App\Models\Role;
use App\Models\TeamMember;
use App\Models\ProjectAssignment;

class UserController extends Controller
{
  
  public function profile(Request $request)
  {
    $user_id=$request->user()->id;
    $user_data=User::where("id",$user_id)
                     ->first();
    $teams=TeamMember::where("user_id",$user_id)
                      ->select("team_id")
                      ->distinct()
                      ->get();
    
    $user_data["teams"]=$teams;                  
                      
    $project=ProjectAssignment::where("assigner_id",$user_id)
                              ->orWhere("worker_id",$user_id)
                              ->select("project_id")
                              ->distinct()
                              ->get();
                      
    $user_data["projects"]=$project;
    $user_data["role"]=$request->user()->roles[0]["name"];
    
    $response=new Response($user_data,200);
    return ResponseStatus::set_status($response,"user-profile");
  }
  
  public function login(Request $request) 
  {
    $credentials = $request->only('email', 'password');
    $device = $request->header('User-Agent');

    if (Auth::attempt($credentials)) {
      $user = Auth::user();
      $token = $user->createToken($device)->plainTextToken;
      return response()->json(['token' => $token]);
    }
    
    $response=new Response(null,401);
    return ResponseStatus::set_status($response,"email-password-invalid");
  }
  
  public function logout(Request $request)
  {
    $request->user()->currentAccessToken()->delete();
    $response=new Response(null,200);
    return ResponseStatus::set_status($response,"logout-success"); 
  }
  
  public function token_list(Request $request)
  {
    $user_id=$request->user()->id;
    $tokens=PersonalAccessToken::where('tokenable_id',$user_id)
                                  ->select("id","name","created_at","last_used_at")
                                 ->get();
    $response=new Response($tokens,200);
    return ResponseStatus::set_status($response,"token-list");
  }
  
  public function token_delete(Request $request,$token_id)
  {
    $request->user()->tokens()->where('id', $token_id)->delete();
    $response=new Response(null,200);
    return ResponseStatus::set_status($response,"token-delete");
  }
  
  public function add(Request $request)
  {
    $username=$request->input("username");
    $email=$request->input("email");
    $rolename=$request->input("role");
    $password=Str::random(12);
    
    $user = User::create([
      'name' => $username,
      'password' => Hash::make($password),
      'email' => $email,
    ]);
    
    $role = Role::findByParam(["name" => $rolename]);
    $user->assignRole($role);
    
    dispatch(new QueueEmailPassword($email,$username,$password));
    
    $response=new Response(null,200);
    return ResponseStatus::set_status($response,"user-create-success");
  }
  
}