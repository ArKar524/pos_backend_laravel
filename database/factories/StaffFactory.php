<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $genderOptions = ['Male','Female','Other'];
        $gender = fake()->randomElement($genderOptions);

        $positionOptions = ['Cashier', 'Manager', 'Supervisor', 'Sales Associate', 'Inventory Clerk'];
        $position = fake()->randomElement($positionOptions);

        return [
            // "StaffCode"=> "Stf_". Str::random(8),
            "staffCode" => "Stf_".mt_rand(3000, 999999),
            "staffName" => fake()->name(),
            "dateOfBirth" => fake()->date(),
            "mobileNo" => fake()->phoneNumber(),
            "address" => fake()->address(),
            "gender" => $gender,
            "position" => $position,
            "shop_id" => rand(1,10),
            
            
        ];
    }
}
