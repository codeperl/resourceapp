<?php


namespace App\Services\Contracts;


interface MessagableContract
{
    public function success($message): array;
    public function failed($message): array;
}
