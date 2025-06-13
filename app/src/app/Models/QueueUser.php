<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QueueUser extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'queue_id'];
}
