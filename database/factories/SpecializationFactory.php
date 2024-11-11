<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialization>
 */
class SpecializationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specializations = [
            "Allgemeinmediziner", "Anästhesist", "Augenarzt", "Chirurg", "Dermatologe", 
            "Endokrinologe", "Gastroenterologe", "Gynäkologe", "HNO-Arzt", "Kardiologe", 
            "Nephrologe", "Neurologe", "Onkologe", "Orthopäde", "Pädiater", 
            "Psychiater", "Radiologe", "Rheumatologe", "Urologe", "Zahnarzt"
        ];

        return [
            'name' => $this->faker->unique()->randomElement($specializations),
        ];
    }
}