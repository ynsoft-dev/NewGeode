<?php

namespace App\Helpers;

class Helper
{

    public static function IDGenerator($model, $trow, $length = 4, $prefix = '')
    {
        $year_last_two_digits = date('y');
        // Vérifie s'il existe déjà des enregistrements
        $existingRecords = $model::count();
    
        if ($existingRecords === 0) {
            // Aucun enregistrement trouvé, alors on commence à partir de 1
            return $prefix . $year_last_two_digits . str_pad('1', 6, '0', STR_PAD_LEFT);
        }
    
        // Getting last inserted record data
        $data = $model::orderBy('id', 'desc')->first();
    
        // Get last code without prefix
        $code = substr($data->$trow, strlen($prefix) + 2, 6); // Ignorer les 2 premiers chiffres de l'année
    
        // Remove the first 0000 in the beginning
        $actual_last_number = (int) $code;
        $increment_last_number = $actual_last_number + 1;
        $last_number_length = strlen($increment_last_number);
        $og_length = 6 - $last_number_length;
    
        $zeros = str_repeat("0", $og_length);
    
        return $prefix . $year_last_two_digits . $zeros . $increment_last_number;
    }
}
