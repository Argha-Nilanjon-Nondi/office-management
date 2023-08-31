<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Traits\UuidTrait;

class Permission extends SpatiePermission
{
    use UuidTrait;
    protected $keyType = 'string';
    public $incrementing = false;
}
