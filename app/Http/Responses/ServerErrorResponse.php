<?php

namespace App\Http\Responses;

use App\Constants\ErrorCodes;
use Throwable;

class ServerErrorResponse extends ErrorResponse
{
    public function __construct(Throwable $e,
                                int       $status = 500,
                                array     $headers = [])
    {
        $message = __("Internal server error occurred. Please, try again later");

        parent::__construct(
            message: $message,
            code: ErrorCodes::SERVER_ERROR,
            file: $e->getFile(),
            line: $e->getLine(),
            status: $status,
            headers: $headers
        );
    }
}
