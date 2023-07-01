<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use function MongoDB\BSON\toJSON;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    protected $model = \App\Models\Inventory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'name' => $this->faker->word,
            'price' => $this->faker->randomNumber(),
            'quantity' => $this->faker->randomNumber(),
            'delivery_fee' => 1,
            'sku' => $this->faker->uuid,
            'description' => $this->faker->text,
            'additional_data' => json_encode(array(['foo' => 'bar'])),
            'images' => $this->faker->imageUrl() . ',' . $this->faker->imageUrl(),
            'user_id' => User::first()->id
        ];
    }
}
