<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Providers\ArtisanServiceProvider;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            CategorySeeder::class,
            JenisSeeder::class,
            PendidikanSeeder::class,
            TingkatSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            ArticleSeeder::class,
            PageSeeder::class,
            AdminSeeder::class,
        ]);
    }
    
    
}
