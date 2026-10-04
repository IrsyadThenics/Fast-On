<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    public function permissions()
    
    {
    return $this->belongsToMany(Permission::class);
    }

    protected $fillable = [
        'name',
        'role_code',
        'type',
        'ulp_id',
    ];

    public function ulp()
    {
        return $this->belongsTo(Ulp::class);
    }
}
