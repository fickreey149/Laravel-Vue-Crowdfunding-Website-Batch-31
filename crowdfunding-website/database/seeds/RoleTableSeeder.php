<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => Str::uuid(),
                'name' => 'admin'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'user'
            ]
        ];
        DB::table('roles')->insert($roles);
    }
}
