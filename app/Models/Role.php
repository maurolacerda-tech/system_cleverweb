<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name', 'label'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'label']);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'permission_role');
    }
}

