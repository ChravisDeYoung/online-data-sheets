<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = Role::all();

        User::factory()
            ->create([
                'first_name' => 'Travis',
                'last_name' => 'De Jong',
                'email' => 'travis.dejong@eventconnect.io',
            ])
            ->roles()
            ->attach($roles->where('name', 'admin')->first());

        // create 10 users with 3 random roles each
        User::factory(10)
            ->create()
            ->each(fn($user) => $user
                ->roles()
                ->attach($roles
                    ->where('name', '!=', 'admin')
                    ->random(3)));
    }
}
