<?php

namespace Database\Seeders;

use App\Models\RoleUsers;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listArray = [
            [
                'name' => 'Mauro Lacerda',
                'email' => 'suporte@cleverweb.com.br',
                'image' => null,
                'password' => bcrypt('suasenhaaqui'),
                'status' => 1
            ]
        ];
        User::insert($listArray);

        RoleUsers::create([
            'role_id' => 1,
            'user_id' => 1
        ]);
    }
}
