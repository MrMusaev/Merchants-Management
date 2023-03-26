<?php

namespace App\Http\Data\Api\Merchants;

use Spatie\LaravelData\Data;

class FilterData extends Data
{
    public function __construct(
        public ?int    $status = null,
        public ?string $keyword = null,
        public ?string $sort_field = 'id',
        public ?string $sort_direction = 'asc',
        public ?int    $per_page = 20,
        public ?float  $lat = null,
        public ?float  $lng = null,
    )
    {
    }
}
