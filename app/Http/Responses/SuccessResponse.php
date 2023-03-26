<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class SuccessResponse extends Response
{
    public function __construct($data = [], $code = 1, $status = 200, array $headers = [])
    {
        $content = [
            'code' => $code,
            'data' => $data
        ];
        parent::__construct($content, $status, $headers);
    }
}
