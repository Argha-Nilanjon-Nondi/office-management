<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class ResponseStatus {

  public static $custom_code = [
    "login-success" => [
      "code" => 2000,
      "msg" => "login is successful"
    ],
    "user-create-success" => [
      "code" => 2001,
      "msg" => "user is created"
    ],
    "team-create-success" => [
      "code" => 2002,
      "msg" => "team is created"
    ],
    "project-create-success" => [
      "code" => 2003,
      "msg" => "project is created"
    ],
    "project-assign-success" => [
      "code" => 2004,
      "msg" => "project is assigned to the team"
    ],
    "user-assign-success" => [
      "code" => 2005,
      "msg" => "user is assigned to the team"
    ],
    "project-log-stored"=> [
      "code" => 2006,
      "msg" => "project log is stored"
    ],
    "username-invalid" => [
      "code" => 3000,
      "msg" => "username is not valid"
    ],
    "username-empty" => [
      "code" => 3001,
      "msg" => "username is required"
    ],
    "email-empty" => [
      "code" => 3002,
      "msg" => "email is required"
    ],
    "email-invalid" => [
      "code" => 3003,
      "msg" => "email is not valid"
    ],
    "password-empty" => [
      "code" => 3004,
      "msg" => "password is required"
    ],
    "password-invalid" => [
      "code" => 3005,
      "msg" => "password is not valid"
    ],
    "email-password-invalid" => [
      "code" => 3006,
      "msg" => "email or password is incorrect"
    ],
    "token-invalid" => [
      "code" => 3007,
      "msg" => "token is not valid"
    ],
    "email-already-exit" => [
      "code" => 3008,
      "msg" => "email is already exist"
    ],
    "role-not-allowed" => [
      "code" => 3009,
      "msg" => "role is not allowed for this user"],
  ];

  public static function set_status(Response $response, string $action_name) {
    $msg = self::$custom_code[$action_name]["msg"];
    $code = self::$custom_code[$action_name]["code"];
    $response->header("Custom-Status-Message", $msg);
    $response->header("Custom-Status-Code", $code);
    return $response;
  }

}