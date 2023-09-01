<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $primaryKey = 'project_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable =["project_name","project_info"];
}
