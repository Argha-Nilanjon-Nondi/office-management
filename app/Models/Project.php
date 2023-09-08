<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'projects';
    protected $primaryKey = 'project_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable =["project_name","project_info"];
    public static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->project_id = Str::uuid();
    });
  }
}
