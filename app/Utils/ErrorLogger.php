<?php

namespace App\Utils;

class ErrorLogger
{
    public static function log(string $message, \Exception $exception, $request = null)
    {
        \Log::error($message, [
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'request' => $request ? $request->all() : null,
        ]);
    }
}
