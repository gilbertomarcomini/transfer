<?php

namespace App\Libraries;

class Validate
{

    public static function emailValidator($email)
    {
        $count = "^[a-zA-Z0-9\._-]+@";
        $domain = "[a-zA-Z0-9\._-]+.";
        $extension = "\.([a-zA-Z]{2,4})$";
        $pattern = $count . $domain . $extension;
        if (!preg_match('/' . $pattern . '/', $email)) {
            return $email = false;
        } else {
            return $email;
        }
    }

    public static function validateCpf($cpf)
    {
        $cpf = preg_replace('/[^a-zA-Z0-9]/', '', (string) $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        if (strlen($cpf) != 11){
            return false;
        }

        if (
            $cpf == "00000000000" ||
            $cpf == "11111111111" ||
            $cpf == "22222222222" ||
            $cpf == "33333333333" ||
            $cpf == "44444444444" ||
            $cpf == "55555555555" ||
            $cpf == "66666666666" ||
            $cpf == "77777777777" ||
            $cpf == "88888888888" ||
            $cpf == "99999999999"
        ) {
            return false;
        }

        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--){
            $soma += $cpf[$i] * $j;
        }

        $resto = $soma % 11;
        if ($cpf[9] != ($resto < 2 ? 0 : 11 - $resto)){
            return false;
        }
        
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--){
            $soma += $cpf[$i] * $j;
        }
        
        $resto = $soma % 11;

        return $cpf[10] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public static function validateCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^a-zA-Z0-9]/', '', (string) $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);

        if (strlen($cnpj) != 14) {
            return false;
        }

        $invalid = [
            '00000000000000',
            '11111111111111',
            '22222222222222',
            '33333333333333',
            '44444444444444',
            '55555555555555',
            '66666666666666',
            '77777777777777',
            '88888888888888',
            '99999999999999'
        ];

        if (in_array($cnpj, $invalid)) {
            return false;
        }
        
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        
        $rest = $sum % 11;
        
        return $cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
    }

}