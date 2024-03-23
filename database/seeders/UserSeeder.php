<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            "fullname" => "Evgeniy Digtyarenko",
            "username" => "dispache",
            "email" => "e.digtyarenko3@gmail.com",
            "password" => Hash::make("qwerty3"),
            "image" => env("IMAGE_PROFILE"),
            "phone" => "0955683560",
            "gender" => "M",
            "address" => "Dnipro",
            "role_id" => 1,
            "coupon" => 0,
            "point" => 0,
            'remember_token' => Str::random(30),
        ]);

        User::factory(5)->create();
    }
}
