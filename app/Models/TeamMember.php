<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;

class TeamMember extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'team_members';
    protected $primaryKey = 'pair_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable=["team_id","user_id"];
    public static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->pair_id = Str::uuid();
    });
  }
}
