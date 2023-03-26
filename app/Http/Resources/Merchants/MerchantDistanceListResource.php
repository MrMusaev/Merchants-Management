<?php

namespace App\Http\Resources\Merchants;

use App\Http\Resources\User\UserListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantDistanceListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'distance' => [
                'number' => floatval($this->distance),
                'text' => meter_distance_to_text(floatval($this->distance)),
            ],
            'status' => [
                'code' => $this->status,
                'label' => $this->status_label
            ],
            'creator' => UserListResource::make($this->creator),
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
