<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // The test user relies on fakerphp/faker (require-dev), which is NOT
        // installed on production (composer install --no-dev). Seeding it there
        // fatals with "Call to undefined function fake()" and aborts the whole
        // seed run before the content seeders execute. Restrict it to local/testing.
        if (app()->environment('local', 'testing')) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            ContentMachineSeeder::class,
        ]);
    }
}
