<?php

namespace App\Http\Responses;

use Exception;

class ApiErrorResponse extends ErrorResponse
{
    public function __construct(Exception $e,
                                int       $status = 500,
                                array     $headers = [])
    {
        parent::__construct(
            message: $e->getMessage(),
            code: $e->getCode(),
            file: $e->getFile(),
            line: $e->getLine(),
            status: $status,
            headers: $headers
        );
    }
}
