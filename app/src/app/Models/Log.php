<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use SoftDeletes;

    protected $fillable = ['url', 'ip', 'user_id', 'register'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
