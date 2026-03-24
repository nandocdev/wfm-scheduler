<?php

namespace Database\Seeders;

use App\Modules\CoreModule\Models\Role;
use App\Modules\CoreModule\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            PanamaGeographySeeder::class,
            RolesAndPermissionsSeeder::class,
            UsersPerRoleSeeder::class,
        ]);

        $adminRole = Role::query()->where('name', 'admin')->where('guard_name', 'web')->first();

        if ($adminRole !== null) {
            $testUser->syncRoles([$adminRole->name]);
        }
    }
}
