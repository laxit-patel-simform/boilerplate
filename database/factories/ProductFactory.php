<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Region;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(45),
            'category_id' => fake()->randomElement(Category::pluck('name')->toArray()),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $zones = Zone::inRandomOrder()->take(rand(1, 3))->get(); // Adjust number of regions to attach randomly
            foreach ($zones as $zone) {
                $product->zones()->attach($zone->id, ['price' => fake()->randomFloat(2, 0, 100)]);
            }

            $product->image()->create(['path' => 'https://via.placeholder.com/150']);
        });
    }
}
