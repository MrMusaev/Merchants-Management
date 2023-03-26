<?php

namespace App\Http\Resources\Merchants;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantListResource extends JsonResource
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
            'status' => [
                'code' => $this->status,
                'label' => $this->status_label
            ]
        ];
    }
}
