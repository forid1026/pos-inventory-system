<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(1)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        Customer::create([
            'name' => 'Walk in Customer',
            'email' => 'walkin@gmail.com',
            'status' => 'active',
        ]);

        $this->call([
            SiteSettingSeeder::class,
            CategorySeeder::class
        ]);

    }
}
