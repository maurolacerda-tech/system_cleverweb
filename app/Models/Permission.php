<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{    
    protected $fillable = [
        'name', 'label', 'group_name',
    ];

    const GROUP_LIST = [
        'system' => 'Sistema',
        'site' => 'Site'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
