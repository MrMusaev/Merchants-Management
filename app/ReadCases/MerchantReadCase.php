<?php

namespace App\ReadCases;

use App\Http\Data\Api\Merchants\FilterData;
use App\Models\Merchants\Merchant;
use Illuminate\Database\Eloquent\Builder;

class MerchantReadCase
{
    private function baseQuery(): Builder
    {
        return Merchant::query();
    }

    public function filter(FilterData $data): Builder
    {
        $query = $this->baseQuery();

        $this->addKeywordFilter($query, $data->keyword);
        $this->addStatusFilter($query, $data->status);

        return $query;
    }

    public function addKeywordFilter(Builder $query, ?string $keyword): void
    {
        $query->when($keyword, function (Builder $query, $keyword) {
            return $query->where('name', 'ilike', "%$keyword%");
        });
    }

    public function addStatusFilter(Builder $query, ?int $status): void
    {
        $query->when($status, function (Builder $query, $status) {
            return $query->where('status', '=', $status);
        });
    }

    public function addSort(Builder $query, string $sort_field, string $sort_direction): void
    {
        $query->orderBy($sort_field, $sort_direction);
    }
}
