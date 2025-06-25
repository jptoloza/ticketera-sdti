<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'status_id', 'priority_id', 'user_id',
        'queue_id', 'subject', 'message',
        'files', 'created_by', 'assigned_agent'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
    
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_agent');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }


    public function logs()
    {
        return $this->hasMany(LogTicket::class);
    }
}
