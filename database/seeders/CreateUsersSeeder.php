<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Admin User',
               'email'=>'admin@gmail.com',
               'jenis_kelamin'=>'Laki-laki',
               'noHp'=>'082333098123',
               'gambar'=>'none',
               'type'=>0,
               'password'=> bcrypt('123456'),
            ],
            [
               'name'=>'User',
               'email'=>'user@gmail.com',
               'jenis_kelamin'=>'Perempuan',
               'noHp'=>'082333098123',
               'gambar'=>'none',
               'type'=>1,
               'password'=> bcrypt('123456'),
            ],

            [
                'name'=>'Eka',
                'email'=>'eywidyanti@gmail.com',
                'jenis_kelamin'=>'Perempuan',
                'noHp'=>'082333098123',
                'gambar'=>'none',
                'type'=>0,
                'password'=> bcrypt('123456'),
             ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }

    }
}
