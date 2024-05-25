<?php
namespace App\Helpers;

class Helper
{
    public static function IDGenerator($model, $trow, $length = 6, $prefix = '')
    {
        $year = date('y'); // Récupère les deux derniers chiffres de l'année actuelle (ex : 2024 -> 24)
        $yearPrefix = $year; // Les deux derniers chiffres de l'année
        $prefix .= $yearPrefix; // Ajoute les deux derniers chiffres de l'année au préfixe

        $data = $model::orderBy('id', 'desc')->first();

        if (!$data) {
            $last_number = 1;
        } else {
            $code = substr($data->$trow, strlen($prefix));
            if (is_numeric($code)) {
                $last_number = (int)$code + 1;
            } else {
                $last_number = 1;
            }
        }

        $last_number = str_pad($last_number, $length, '0', STR_PAD_LEFT); // Ajoute des zéros devant le numéro

        return $prefix . $last_number;
    }
}
?>