<?php

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
        DB::statement('SET SESSION sql_mode=\'NO_AUTO_VALUE_ON_ZERO\'');
        DB::statement('SET SESSION FOREIGN_KEY_CHECKS=0');

        DB::table('users')->insert([[
            'id'        => '0',
            'role_id'   => '1',
            'parent_id' => '0',
            'name'      => 'super_admin',
            'email'     => 'super_admin@donbass.net',
            'password'  => Hash::make('gunck7iaf'),
            'created_at'=> 'NOW()',
            'updated_at'=> 'NOW()'
        ],[
            'id'        => '1',
            'role_id'   => '1',
            'parent_id' => '0',
            'name'      => 'admin',
            'email'     => 'noc@donbass.net',
            'password'  => Hash::make('gunck7iaf'),
            'created_at'=> now(),
            'updated_at'=> now()
        ]]);

        DB::statement('SET SESSION FOREIGN_KEY_CHECKS=1');
    }
}
