<?php

namespace App\Http\Helpers;

use \Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UtilHelper
{
    
    
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
        $_stringDate .= ' de ' . UtilHelper::mes($_date[1]) . ' ' . $_date[0];
        return $_stringDate;
    }


    /**
     *
     * Generates a string with the first capitalized letter of each word.
     * @param $string
     * @param $newString
     */
    public static function ucTexto($string, $delimiters = array(" "))
    {
        $exceptions = array("y", "de", "al", "en", "e", "N/A", "UA:", "DRA:", "UA", "del", "PSU", "UC", "VRA", "para", "la", "y/o", "I", "II", "III", "IV", "V", "i", "ii", "iii", "iv", "v");
        $string = mb_convert_case($string, MB_CASE_TITLE);
        foreach ($delimiters as $dlnr => $delimiter) {
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $word) {
                if (in_array(mb_strtoupper($word), $exceptions)) {
                    $word = mb_strtoupper($word);
                } elseif (in_array(mb_strtolower($word), $exceptions)) {
                    $word = mb_strtolower($word);
                } elseif (!in_array($word, $exceptions)) {
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
        }
        // exclude
        $string = preg_replace("/^de/", "De", $string);
        $string = preg_replace("/^en/", "En", $string);
        return $string;
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


    /**
     * 
     */
    public static function removeAccents($string)
    {
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    }


    /**
     * 
     * 
     */
    public static function globalKey($key = null)
    {
        if (is_null($key)) return null;

        $modelArray = explode("_",$key);
        $modelName = mb_convert_case($modelArray[0], MB_CASE_TITLE);

        $modelInstance = app('App\\Models\\' . $modelName);
        $record = $modelInstance::where('global_key', '=', $key)->where('active',true)->first();
        return is_null($record) ? null : $record->id;

    }

}
