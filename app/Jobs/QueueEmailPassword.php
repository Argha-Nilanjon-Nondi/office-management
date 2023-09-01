<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordEmail;

class QueueEmailPassword implements ShouldQueue
{
  use Dispatchable,
  InteractsWithQueue,
  Queueable,
  SerializesModels;

  /**
  * Create a new job instance.
  */
  public $email;
  public $username;
  public $password;
  
  public function __construct($email,$username,$password) {
    $this->email=$email;
    $this->username=$username;
    $this->password=$password;
  }

  /**
  * Execute the job.
  */
  public function handle(): void
  {
    Mail::to($this->email)->send(new PasswordEmail($this->username, $this->password));
  }
}