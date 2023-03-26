<?php

namespace App\Http\Data\Api\Merchants;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class EditData extends Data
{

    public function __construct(
        public int|Optional    $merchant_id,
        public string|Optional $name,
        public float|Optional  $lat,
        public float|Optional  $lng,
    )
    {
    }
}
