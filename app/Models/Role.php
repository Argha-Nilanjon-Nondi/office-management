<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use App\Traits\UuidTrait;

class Role extends SpatieRole
{
    use UuidTrait;
    protected $keyType = 'string';
    public $incrementing = false;
}
