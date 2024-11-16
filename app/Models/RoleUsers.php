<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    public $table = "role_user";

    protected $fillable = [
        'role_id', 'user_id',
    ];
}
