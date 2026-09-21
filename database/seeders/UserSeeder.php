<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::firstOrCreate(
            ['email' => 'admin@constituencyproject.org'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $user->forceFill(['admin' => true, 'role' => 'admin'])->save();
    }
}
