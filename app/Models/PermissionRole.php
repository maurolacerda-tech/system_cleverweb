<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    public $table = "permission_role";

    protected $fillable = [
        'permission_id', 'role_id',
    ];
}