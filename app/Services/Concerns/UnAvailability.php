<?php
namespace App\Services\Concerns;

trait UnAvailability
{
    public function unAvailable($conditional, $resourceKlass, $message)
    {
        if($conditional) {
            return (new $resourceKlass(null))
                ->additional(
                    [
                        'status' => false,
                        'message' => $message,
                    ]
                );
        }
    }
}
