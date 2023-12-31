<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //create roles and permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // \App\Models\User::factory(10)->create();
        // Company::factory(101)->create();

        // Create admin user
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'support@unicoreonline.com',
            'password' => bcrypt('Unic0r3'),
        ]);
        // Assign the "admin" role to the user
        $adminRole = Role::findByName('admin');
        $user->assignRole($adminRole);
    }
}
