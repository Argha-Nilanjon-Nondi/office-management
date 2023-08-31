<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class UserController extends Controller
{
  public function login(Request $request) {
    $credentials = $request->only('email', 'password');
$device= $request->header('User-Agent');

    if (Auth::attempt($credentials)) {
      $user = Auth::user();
      $token = $user->createToken($device)->plainTextToken;
      return response()->json(['token' => $token]);
    }
    return "Not Login worked";
  }
}