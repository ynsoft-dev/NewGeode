<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(SitesTableSeeder::class);
        $this->call(RaysTableSeeder::class);
        $this->call(ColumnsTableSeeder::class);
        $this->call(DirectionsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(ShelvesTableSeeder::class);
    }
}
