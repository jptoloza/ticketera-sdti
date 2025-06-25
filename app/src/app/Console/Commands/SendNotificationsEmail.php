<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Notification;
use App\Models\TicketMessage;
use App\Mail\EmailNotification;
use Illuminate\Console\Command;
use App\Models\TypeNotification;
use Illuminate\Support\Facades\Mail;

class SendNotificationsEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notifications-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notifications by Email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //

        $notifications = Notification::where('execute', '=', false)->get();

        foreach ($notifications as $notification) {
            $type = TypeNotification::find($notification->type_notification_id);
            $register_id = $notification->register_id;
            $ticket = null;
            $message = null;
            $content = null;
            switch ($type->type) {
                case 'NEW':
                    $ticket = Ticket::find($register_id);
                    $user   = User::find($ticket->user_id);
                    $created_by = User::find($ticket->created_by);
                    $content = (object) [
                        'ticket'    => $ticket,
                        'user'      => $user,
                        'created_by'=> $created_by,
                        'assigned'  => $ticket->assigned_agent != 0 ? User::find($ticket->assigned_agent)->toArray() : null,
                    ];


                    try {
                        //Mail::to($content->user->email)->send(new EmailNotification('NEW', $content));
                        Mail::to("jponce@uc.cl")->send(new EmailNotification('NEW', $content));
                    } catch (\Exception $e) {
                        // Puedes registrar el error o responder con un mensaje
                        echo "Error al enviar el correo: " . $e->getMessage();
                    }


                    break;

                case 'MESSAGE':
                    $message = TicketMessage::find($register_id);
                    $ticket = Ticket::find($message->ticket_id);
                    $user   = User::find($ticket->user_id);
                    $created_by = User::find($ticket->created_by);
                    $content = (object)  [
                        'ticket'    => $ticket->toArray(),
                        'user'      => $user->toArray(),
                        'created_by'=> $created_by,
                        'assigned'  => $ticket->assigned_agent != 0 ? User::find($ticket->assigned_agent)->toArray() : null,
                        'message'   => $message
                    ];
                    break;

                default:
                    break;
            }
        }
    }
}
