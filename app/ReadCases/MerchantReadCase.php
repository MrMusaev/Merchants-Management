<?php

namespace App\ReadCases;

use App\Http\Data\Api\Merchants\FilterData;
use App\Models\Merchants\Merchant;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MerchantReadCase
{
    private function baseQuery(): Builder
    {
        /* @var User $user */
        $user = Auth::user();

        return Merchant::query()
            ->with(['creator'])
            ->when(!$user->isSuperAdmin(), function (Builder $query) use ($user) {
                return $query->where('creator_id', '=', $user->id);
            });
    }

    public function filter(FilterData $data, ?Builder $query = null): Builder
    {
        $query = $query ?: $this->baseQuery();

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

    public function nearest(float $lat, float $lng): Builder
    {
        return $this->baseQuery()
            ->select('*',
                DB::raw("earth_distance(ll_to_earth(lat, lng), ll_to_earth($lat, $lng)) AS distance")
            )
            ->orderBy('distance');
    }

}
