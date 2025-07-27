<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Admin', 'User'];

        foreach ($roles as $key => $role) {
            Role::create([
                'name' => $role,
            ]);
        }

        $admin_role = Role::where('name', 'Admin')->firstOrFail();
        $user_role  = Role::where('name', 'User')->firstOrFail();

        User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make("Admin@123"),
            'role_id'  => $admin_role->id,
        ]);

        User::factory()->create([
            'name'     => 'User',
            'email'    => 'user@gmail.com',
            'password' => Hash::make("user@123"),
            'role_id'  => $user_role->id,
        ]);

        User::factory(30)->create([
            'role_id' => $user_role->id,
        ]);
    }
}
