<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['Admin', 'User'];
        $email = ['admin@mail.ru', 'user@mail.ru'];
        $birthday = ['1997-07-20', '2001-01-01'];
        $biography = 'Короткий текст про меня...';
        $country_id = [1, 2];
        $gender_id = [1, 2];
        $role_id = [1, 3];
        $password = '12345';
        $email_verified_at = [now(), now()];

        for($i = 0; $i < count($name); $i++) {
            $user = new User();
            $user->name = $name[$i];
            $user->email = $email[$i];
            $user->birthday = $birthday[$i];
            $user->biography = $biography;
            $user->country_id = $country_id[$i];
            $user->gender_id = $gender_id[$i];
            $user->role_id = $role_id[$i];
            $user->password = bcrypt($password);
            $user->email_verified_at = $email_verified_at[$i];
            $user->save();
        }
    }
}
