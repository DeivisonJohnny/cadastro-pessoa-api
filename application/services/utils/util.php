<?php

namespace application\services\utils;

use SplitPHP\Service;

class Util extends Service
{

    public static function validatePersonData($data)
    {
        $errors = [];

        if (empty($data['nome'])) {
            $errors[] = 'O campo nome é obrigatório.';
        }

        if (empty($data['email'])) {
            $errors[] = 'O campo email é obrigatório.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Formato de email inválido.';
        }

        if (empty($data['cpf'])) {
            $errors[] = 'O campo CPF é obrigatório.';
        }

        if (empty($data['dataNascimento'])) {
            $errors[] = 'O campo data de nascimento é obrigatório.';
        } elseif (!self::validateDate($data['dataNascimento'])) {
            $errors[] = 'Formato de data de nascimento inválido. Use AAAA-MM-DD.';
        }

        if (empty($data['telefone'])) {
            $errors[] = 'O campo telefone é obrigatório.';
        }

        if (empty($data['endereco'])) {
            $errors[] = 'O campo endereço é obrigatório.';
        }

        return $errors;
    }

    private static function validateDate(string $date, string $format = 'Y-m-d'): bool
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}