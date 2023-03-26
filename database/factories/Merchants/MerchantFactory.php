<?php

namespace Database\Factories\Merchants;

use App\Constants\Status;
use App\Models\Merchants\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Merchant>
 */
class MerchantFactory extends Factory
{
    /**
     * Latitude and longitude boundaries for Ireland
     * Found using ChatGPT
     */
    const MIN_LAT = 51.41;
    const MAX_LAT = 55.38;

    const MIN_LON = -10.48;
    const MAX_LON = -5.99;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'lat' => $this->faker->latitude(self::MIN_LAT, self::MAX_LAT),
            'lng' => $this->faker->longitude(self::MIN_LON, self::MAX_LON),
            'status' => array_rand(Status::getSelection()),
            'creator_id' => 1,
            'updater_id' => 1,
        ];
    }
}
