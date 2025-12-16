<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Tech Innovations Inc.',
                'email' => 'contact@techinnovations.com',
                'phone' => '+1-555-0100',
                'address' => '123 Silicon Valley, CA',
                'website' => 'https://techinnovations.com',
            ],
            [
                'name' => 'Global Solutions Ltd.',
                'email' => 'info@globalsolutions.com',
                'phone' => '+1-555-0200',
                'address' => '456 Business Park, NY',
                'website' => 'https://globalsolutions.com',
            ],
            [
                'name' => 'Creative Designs Co.',
                'email' => 'hello@creativedesigns.com',
                'phone' => '+1-555-0300',
                'address' => '789 Design Street, LA',
                'website' => 'https://creativedesigns.com',
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}