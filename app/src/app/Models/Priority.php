<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
    use SoftDeletes;

    protected $fillable = ['priority', 'global_key', 'active'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
