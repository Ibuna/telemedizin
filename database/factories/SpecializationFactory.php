<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        static $specializations = [
            "Allgemeinmediziner", "Anästhesist", "Augenarzt", "Chirurg", "Dermatologe", 
            "Endokrinologe", "Gastroenterologe", "Gynäkologe", "HNO-Arzt", "Kardiologe", 
            "Nephrologe", "Neurologe", "Onkologe", "Orthopäde", "Pädiater", 
            "Psychiater", "Radiologe", "Rheumatologe", "Urologe", "Zahnarzt"
        ];

        $specialization = array_pop($specializations);

        return [
            'name' => $specialization,
        ];
    }
}
