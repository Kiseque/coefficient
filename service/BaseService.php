<?php

namespace App\service;

require_once 'bootstrap.php';
class BaseService
{
    protected function mb_ucfirst(string $string): string
    {
        return !empty($string) ? mb_strtoupper(mb_substr($string,0,1)) . mb_substr($string, 1) : $string;
    }

}