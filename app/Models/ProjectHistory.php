<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectHistory extends Model
{
    use HasFactory;
    protected $table = 'projects_history';
    protected $casts = [
        'extra' => 'array',
    ];
    protected $fillable =["project_id","team_id","project_manager_id","progress_info","project_status","extra"];
}
