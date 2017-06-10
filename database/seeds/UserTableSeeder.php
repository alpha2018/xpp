<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        DB::table('users')->insert([
//           'name' => str_random(10),
//           'email' => str_random(10).'@gmail.com',
//           'password' => bcrypt('secret'),
//       ]);

        factory('Modules\Admin\Models\User', 50)->create();

//        DB::table('role_user')->insert([
//            'role_id' => rand(1,100),
//            'user_id' => rand(1,100),
//        ]);

    }
}
