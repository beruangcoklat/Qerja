<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;

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
        $user->fullname = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('admin');
        $user->verifyToken = Str::random(40);
        $user->status = 1;
        $user->role_id = 2;
        $user->image = 'pepsi.png';
        $user->save();

        $user = new User;
        $user->fullname = 'yulian';
        $user->email = 'yuliangunawan19@gmail.com';
        $user->password = bcrypt('pw');
        $user->verifyToken = Str::random(40);
        $user->status = 1;
        $user->role_id = 1;
        $user->image = 'pepsi.png';
        $user->save();

        $user = new User;
        $user->fullname = 'budi';
        $user->email = 'budi@gmail.com';
        $user->password = bcrypt('budi');
        $user->verifyToken = Str::random(40);
        $user->status = 1;
        $user->role_id = 1;
        $user->image = 'pepsi.png';
        $user->save();
    }
}
