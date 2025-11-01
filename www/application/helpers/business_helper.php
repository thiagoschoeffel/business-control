<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('datetime_br_to_db')) {

    function datetime_br_to_db($datetime)
    {
        $dt = explode(' ', $datetime);
        $d = explode('/', $dt[0]);
        $t = $dt[1];

        return $d[2] . '-' . $d[1] . '-' . $d[0] . ' ' . $t;
    }

}

if (!function_exists('date_br_to_db')) {

    function date_br_to_db($date)
    {
        $d = explode('/', $date);

        return $d[2] . '-' . $d[1] . '-' . $d[0];
    }

}

if (!function_exists('check_datetime')) {

    function check_datetime($date_time_start, $date_time_finish = null)
    {
        
    }

}

if (!function_exists('check_date')) {

    function check_date($date_start, $date_finish = null)
    {
        
    }

}

if (!function_exists('string_to_decimal')) {

    function string_to_decimal($string)
    {
        return str_replace(',', '.', str_replace('.', '', $string));
    }

}

if (!function_exists('decimal_format')) {

    function decimal_format($number, $decimals = 2, $unity)
    {
        return number_format($number, $decimals, ',', '.') . $unity;
    }

}

if (!function_exists('validation_message')) {

    function validation_message($validations_errors)
    {
        return [
            'type' => 'warning',
            'message' => CONF_MESSAGE_VALIDATION . '<ul class="mb-0 mt-2">' . $validations_errors . '</ul>'
        ];
    }

}