<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'rut',
        'login',
        'email',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function queues()
    {
        return $this->belongsToMany(Queue::class, 'queue_users');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

}
