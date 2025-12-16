<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('No companies found. Run CompanySeeder first.');
            return;
        }

        foreach ($companies as $company) {
            // Create CEO
            $ceo = Employee::create([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'position' => 'CEO',
                'salary' => 200000,
                'company_id' => $company->id,
                'manager_id' => null,
                'country' => 'United States',
                'state' => 'California',
                'city' => 'San Francisco',
                'hire_date' => now()->subYears(5),
            ]);

            // Create some employees reporting to CEO
            for ($i = 0; $i < 5; $i++) {
                Employee::create([
                    'first_name' => fake()->firstName(),
                    'last_name' => fake()->lastName(),
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->phoneNumber(),
                    'position' => fake()->randomElement(['Manager', 'Developer', 'Designer', 'Analyst']),
                    'salary' => fake()->numberBetween(50000, 100000),
                    'company_id' => $company->id,
                    'manager_id' => $ceo->id,
                    'country' => 'United States',
                    'state' => fake()->randomElement(['California', 'New York', 'Texas']),
                    'city' => fake()->city(),
                    'hire_date' => now()->subYears(rand(1, 3)),
                ]);
            }
        }
    }
}