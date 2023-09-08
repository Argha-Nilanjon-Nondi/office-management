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
    "project-log-stored" => [
      "code" => 2006,
      "msg" => "project log is stored"
    ],
    "assignment-create-success" => [
      "code" => 2007,
      "msg" => "assignment is added"
    ],
    "team-list" => [
      "code" => 2008,
      "msg" => "team list is retrieved"
    ],
    "single-team" => [
      "code" => 2009,
      "msg" => "single team data is retrieved"
    ],
    "project-list" => [
      "code" => 2010,
      "msg" => "project list is retrieved"
    ],
    "single-project" => [
      "code" => 2011,
      "msg" => "single project data is retrieved"
    ],
    "project-log-list" => [
      "code" => 2012,
      "msg" => "project log list is retrieved"
    ],

    "single-assignment" => [
      "code" => 2013,
      "msg" => "single assignment data is retrieved"
    ],
    "assignment-list" => [
      "code" => 2014,
      "msg" => "assignment list is retrieved"
    ],
    "user-profile" => [
      "code" => 2015,
      "msg" => "user profile is retrieved"
    ],
    "logout-success" => [
      "code" => 2016,
      "msg" => "user is logout"
    ],
    "token-list" => [
      "code" => 2017,
      "msg" => "token list is retrieved"
    ],
    "token-delete" => [
      "code" => 2018,
      "msg" => "token is deleted"
    ],
    "object-history-list" => [
      "code" => 2019,
      "msg" => "history object list is retrieved"
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