<?php

use App\User;
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
        $user = new User;
        $user->type = 'superuser';
        $user->name = 'Jovert Palonpon';
        $user->username = 'icadirci';
        $user->email = 'ibrahimh.cadirci@gmail.com';
        $user->password = bcrypt('password');

        $user->firstname = 'İbrahim';
        $user->middlename = 'Halil';
        $user->lastname = 'Çadırcı';
        $user->gender = 'male';
        $user->birthdate = '1999-04-01';
        $user->address = 'Şanlıurfa, Türkiye';
        $user->save();

    }
}
