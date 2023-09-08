<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class Team extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  use HasFactory;
  protected $table = 'teams';
  protected $primaryKey = 'team_id';
  public $incrementing = false;
  protected $keyType = 'uuid';
  protected $fillable = ["team_name", "team_info"];
  public static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->team_id = Str::uuid();
    });
  }
}