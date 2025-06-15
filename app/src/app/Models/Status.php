<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{

    use SoftDeletes;
    
    protected $table = 'status';

    protected $fillable = ['status', 'global_key', 'active'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
