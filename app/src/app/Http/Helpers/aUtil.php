<?php

namespace App\Http\Helpers;

use \Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use App\Models\Module;
use Illuminate\Support\Facades\Session;

class Util
{

    /**
     */
    public static function insertLog($tableName, $action, $recordId)
    {
        $user_id = Session::get('user')->id;
        $user_login = Session::get('user')->login;
        $log = new Log();
        $log->table = $tableName;
        $log->action = $action;
        $log->record_id = $recordId;
        $log->user_login = $user_login;
        $log->user_id = $user_id;
        $log->save();
        //return "Inserción de log completa";
    }


    /**
     * 
     * 
     */
    public static function mes($mes)
    {
        $meses = array(
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        );
        $mes = (int) $mes;
        return $meses[$mes];
    }


    /**	 
     *
     * 
     */
    public static function dia($i)
    {
        $semana = array(
            '1' => 'Lunes',
            '2' => 'Martes',
            '3' => 'Miércoles',
            '4' => 'Jueves',
            '5' => 'Viernes',
            '6' => 'Sabado',
            '7' => 'Domingo'
        );
        $dia = (int) $i;
        return $semana[$dia];
    }

    /**	 
     * Convierte un fecha 2025-01-01 a : 01 de enero de 2025
     * 
     */
    public static function textDate($textDate)
    {
        $_date = explode("-", $textDate);
        $_stringDate = strlen($_date[2]) == 1 ? '0' . $_date[2] : $_date[2];
        $_stringDate .= ' de ' . Util::mes($_date[1]) . ' ' . $_date[0];
        return $_stringDate;
    }

    /**
     * 
     * 
     */
    public static function navbarName($socialName = '')
    {
        $records = explode(" ", $socialName);
        $navbarName = '';
        $count = 0;
        foreach ($records as $value) {
            $navbarName .= substr($value, 0, 1);
            $count++;
            if ($count >= 2)
                break;
        }
        return $navbarName;
    }

}
