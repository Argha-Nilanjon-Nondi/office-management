<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Http\Response;
use App\Helpers\ResponseStatus;

class Handler extends ExceptionHandler
{
  /**
  * The list of the inputs that are never flashed to the session on validation exceptions.
  *
  * @var array<int, string>
  */
  protected $dontFlash = [
    'current_password',
    'password',
    'password_confirmation',
  ];

  /**
  * Register the exception handling callbacks for the application.
  */
  public function register(): void
  {
    $this->reportable(function (Throwable $e) {
      //
    });
  }

  public function handleApiException($request, Throwable $exception) {

    $methodname = $exception->getTrace()[0]['function'];
    //\Log::error($methodname);

    if ($methodname == "unauthenticated") {
      $response = new Response(null, 401);
      return ResponseStatus::set_status($response, "token-invalid");
    }

    if ($exception instanceof UnauthorizedException) {
      if ($methodname == "forRoles") {
        $response = new Response(null, 401);
        return ResponseStatus::set_status($response, "role-not-allowed");
      }
    } 
    
    else {
      return parent::render($request, $exception);
    }


  }


  public function render($request, Throwable $exception) {
    if ($request->expectsJson()) {
      return $this->handleApiException($request, $exception);
    }

    return parent::render($request, $exception);

  }



}