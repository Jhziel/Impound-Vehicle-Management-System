<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImpoundSlot>
 */
class ImpoundSlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slot_code' => $this->generateUniqueSlotCode(),
            'is_occupied' => fake()->randomElement([False, True])
        ];
    }
    /*  private function generateSlotCode(): string
    {
        $side = fake()->randomElement(['L', 'R', 'T']);
        $number = fake()->unique()->numberBetween(1, 12);

        return "{$side}{$number}";
    } */

    private function generateUniqueSlotCode(): string
    {
        // Ensure the whole combination is unique
        return fake()->unique()->regexify('[LRT]{1}(1[0-2]|[1-9])');
    }
}
