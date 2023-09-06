<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;
use App\Jobs\QueueEmailPassword;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
  
  public function profile(Request $request)
  {
    $response=new Response(null,200);
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