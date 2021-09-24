<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'root',
            'email' => 'root@root',
            'ROLE' => 'Root',
            'password' => bcrypt('root')
        ]);
        User::create([
            'name' => 'user',
            'email' => 'user@user',
            'ROLE' => 'User',
            'password' => bcrypt('user')
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'ROLE' => 'Admin',
            'password' => bcrypt('admin')
        ]);
    }
}
