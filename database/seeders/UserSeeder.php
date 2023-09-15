<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                "name" => "System Administration",
                "email" => "admin@mail.io",
                "password" => Hash::make("password"),
                "email_verified_at" => now(),
                "username" => "admyn",
                "address" => fake()->address(),
                "phone_verified_at" => now(),
                "creation_mark" => "X4RTX",
                "gender" => "male",
            ],
            [
                "name" => "Lopein",
                "email" => "partner@mail.io",
                "password" => Hash::make("password"),
                "email_verified_at" => now(),
                "username" => "partneao",
                "address" => fake()->address(),
                "phone_verified_at" => now(),
                "creation_mark" => "PLOX",
                'gender' => 'male',
            ],
        ];

        $roles = [
            ["admin", "user"],
            ["user"],
        ];

        $index = 0;

        foreach ($users as $_user) {

            $user = User::create($_user);

            if ($user instanceof User) {
                $user->assignRole($roles[$index]);

                $user->preferences()->sync([
                    "1" => ["value" => true],
                ], false);
            }

            $index++;
        }

    }
}
