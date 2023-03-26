<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class ErrorResponse extends Response
{
    public function __construct(string $message = '',
                                int    $code = 0,
                                string $file = '',
                                string $line = '',
                                int    $status = 500,
                                array  $headers = [])
    {
        $content = [
            'code' => $code,
            'data' => [
                'message' => $message,
                'file' => $file,
                'line' => $line
            ]
        ];
        parent::__construct($content, $status, $headers);
    }
}
