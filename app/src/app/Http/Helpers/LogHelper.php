<?php

namespace App\Http\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Session;

class LogHelper
{
  /**
   * 
   */
  public static function insertDatabaseLog($id, $message, $table_name)
  {

    if (!empty(Session::get('user'))) {
      $user_id = Session::get('user')->id;
      $user_login = Session::get('user')->login;
    }else{
      $user_id = 0;
      $user_login = 0;
    }
    $log = new Log();
    $log->table = $table_name;
    $log->action = $message;
    $log->record_id = $id;
    $log->user_login = $user_login;
    $log->user_id = $user_id;
    $log->save();
    if (preg_match('/SQLSTATE/', $message)){
      $message = "Error de base de datos. Código de registro : " . $log->id;
    }
    return $message;
  }

  /**
   * 
   */
  public static function insertLoginLog($table,$action,$user,$id)
  {
    $log = new Log();
    $log->table = $table;
    $log->action = $action;
    $log->record_id = 0;
    $log->user_login = $user;
    $log->user_id = $id;
    $log->save();
  }
}
