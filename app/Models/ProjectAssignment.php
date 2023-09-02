<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAssignment extends Model
{
    use HasFactory;
    protected $table = 'projects_assignment';
    protected $primaryKey = 'assignment_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $casts = [
        'extra' => 'array',
    ];
    protected $fillable =[
                          "team_id",
                          "project_id",
                          "assigner_id",
                          "worker_id",
                          "assignment_name",
                          "assignment_info",
                          "assignment_status",
                          "extra"
                        ];

}
