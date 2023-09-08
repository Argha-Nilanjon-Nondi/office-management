<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class ProjectHistory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'projects_history';
    protected $primaryKey = 'history_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $casts = [
        'extra' => 'array',
    ];
    protected $fillable =["project_id","team_id","project_manager_id","progress_info","project_status","extra"];
    public static function boot() {
    parent::boot();

    static::creating(function ($model) {
      $model->history_id = Str::uuid();
    });
  }
}
