<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<10; $i++){
            $user = User::create([
                'name' => 'Test ' .$i,
                'username' => 'test' .$i,
                'is_admin' => 0,
                'email' => 'test' .$i. '@user.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
            $role = Role::where('id', 5)->first();
            $user->syncRoles($role);
        }
    }
}
