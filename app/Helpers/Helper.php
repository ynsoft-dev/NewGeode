<?php

namespace App\Helpers;

class Helper
{

    public static function IDGenerator($model, $trow, $length = 4, $prefix)
    {
        // Vérifie s'il existe déjà des enregistrements
        $existingRecords = $model::count();

        if ($existingRecords === 0) {
            // Aucun enregistrement trouvé, alors on commence à partir de 1
            return $prefix . '-000001';
        }

        // Getting last inserted record data
        $data = $model::orderBy('id', 'desc')->first();

        // $request_date = $data->request_date;
        // $date_parts = explode('/', $request_date);

        // $year_last_two_digits = substr($date_parts[2], -2);
        // dd($year_last_two_digits);

        // Get last code without prefix
        $code = substr($data->$trow, strlen($prefix) + 1);

        // Remove the first 0000 in the beginning
        $actual_last_number = (int) $code;
        $increment_last_number = $actual_last_number + 1;
        $last_number_length = strlen($increment_last_number);
        $og_length = $length - $last_number_length;

        $zeros = "";
        for ($i = 0; $i < $og_length; $i++) {
            $zeros .= "0";
        }

        return $prefix .  '-' . $zeros . $increment_last_number;
    }
}
