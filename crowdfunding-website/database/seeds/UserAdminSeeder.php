<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->first();
        $users = [
            [
                'id' => Str::uuid(),
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('rahasiahati'),
                'role_id' => $role->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'admin verified',
                'username' => 'adminverified',
                'email' => 'adminverified@test.com',
                'password' => Hash::make('rahasiahati'),
                'role_id' => $role->id
            ]
        ];
        DB::table('users')->insert($users);
    }
}
