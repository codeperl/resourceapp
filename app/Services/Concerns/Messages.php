<?php


namespace App\Services\Concerns;


trait Messages
{
    public function success($message): array
    {
        return [
            'status' => true,
            'message' => $message,
        ];
    }

    public function failed($message): array
    {
        return [
            'status' => false,
            'message' => $message,
        ];
    }
}
