<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Staff']);
        Role::create(['name' => 'Coordinator']);
        Role::create(['name' => 'Chief']);
        Role::create(['name' => 'Admin']);

        $user1 = User::create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('123456'),
            'phone_number' => '82236981385',
        ]);
        $user1->assignRole('Staff');

        $user2 = User::create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('123456'),
            'phone_number' => '82236981385',
        ]);
        $user2->assignRole('Staff');

    }
}
