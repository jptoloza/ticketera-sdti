<?php

namespace App\Console\Commands;

use \Exception;
use App\Models\User;
use App\Models\Queue;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\UserRole;
use App\Models\Notification;
use App\Models\TicketMessage;
use App\Mail\EmailNotification;
use Illuminate\Console\Command;
use App\Http\Helpers\UtilHelper;
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
        try {
            $notifications = Notification::where('execute', '=', false)->get();
            foreach ($notifications as $notification) {
                $type = TypeNotification::find($notification->type_notification_id);
                $register_id 	= $notification->register_id;
                $ticket 	= null;
                $message 	= null;
                $content 	= null;
                $sent 		= true;
                $register 	= '';
                switch ($type->type) {
                    case 'NEW':
                        $ticket 	= Ticket::find($register_id);
                        $user   	= User::find($ticket->user_id);
                        $created_by 	= User::find($ticket->created_by);
                        $status 	= Status::find($ticket->status_id);
                        $queue 		= Queue::find($ticket->queue_id);
                        $content 	= (object) [
                            'ticket'    	=> $ticket,
                            'user'      	=> $user,
                            'created_by' 	=> $created_by,
                            'status'    	=> $status,
                            'queue'     	=> $queue,
                        ];
                        try {
                            Mail::to($content->user->email)->send(new EmailNotification('NEW', $content));
                        } catch (Exception $e) {
                            $register = $e->getMessage();
                            $sent = false;
                        }

                        $notification->execute 	= true;
                        $notification->sent 	= $sent;
                        $notification->register = $register;
                        $notification->save();
                        break;

                    case 'MESSAGE':
                        $message = TicketMessage::find($register_id);
                        $ticket = Ticket::find($message->ticket_id);
                        if ($message->created_by == $ticket->user_id) {
                            $user   = User::find($ticket->assigned_agent);
                            $created_by = User::find($message->created_by);
                        } else {
                            $user   = User::find($ticket->user_id);
                            $created_by = User::find($message->created_by);
                        }
                        $status = Status::find($ticket->status_id);
                        $queue = Queue::find($ticket->queue_id);
                        $content = (object)  [
                            'ticket'    => $ticket,
                            'user'      => $user,
                            'created_by' => $created_by,
                            'status'    => $status,
                            'queue'     => $queue,
                            'message'   => $message
                        ];
                        try {
                            Mail::to($content->user->email)->send(new EmailNotification('MESSAGE', $content));
                        } catch (Exception $e) {
                            $register = $e->getMessage();
                            $sent = false;
                        }
                        $notification->execute = true;
                        $notification->sent = $sent;
                        $notification->register = $register;
                        $notification->save();
                        break;


                    case 'CHANGE_STATUS':
                        $ticket = Ticket::find($register_id);
                        $user   = User::find($ticket->user_id);
                        $status = Status::find($ticket->status_id);
                        $queue = Queue::find($ticket->queue_id);
                        $content = (object)  [
                            'ticket'    => $ticket,
                            'user'      => $user,
                            'status'    => $status,
                            'queue'     => $queue
                        ];
                        try {
                            Mail::to($content->user->email)->send(new EmailNotification('MESSAGE', $content));
                            
                        } catch (Exception $e) {
                            $register = $e->getMessage();
                            $sent = false;
                  }
                        $notification->execute = true;
                        $notification->sent = $sent;
                        $notification->register = $register;
                        $notification->save();
                        break;

                    default:
                        $role_id    = UtilHelper::globalKey('ROLE_ADMINISTRATOR');
                        $users_roles = UserRole::where('role_id', '=', $role_id)->get();
                        $users      = [];
                        foreach ($users_roles as $user_role) {
				$_user = User::find($user_role->user_id);
                            $users[] = $_user->email;
                        }
                        foreach ($users as $user) {
                            try {
                                $content = (object)  [
                                    'register' => $notification->register
                                ];
                                Mail::to($user->email)->send(new EmailNotification('MESSAGE', $content));
                            } catch (Exception $e) {
                                $register = $e->getMessage();
                                $sent = false;
                            }
                        }
                        $notification->execute = true;
                        $notification->sent = $sent;
                        $notification->register = $register;
                        $notification->save();
                        break;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
