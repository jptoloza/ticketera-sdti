<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Queue extends Model
{
    use SoftDeletes;

    protected $fillable = ['queue', 'active'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'queue_users');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
