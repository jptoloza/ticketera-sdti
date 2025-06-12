<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogTicket extends Model
{
    use SoftDeletes;

    protected $fillable = ['ticket_id', 'action', 'data'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
