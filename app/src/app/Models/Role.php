<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = ['role', 'global_key', 'active'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}
