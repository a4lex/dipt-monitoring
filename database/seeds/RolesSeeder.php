<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
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

        DB::table('roles')->insert([[
            'id'        => '0',
            'name'      => 'Empty Role',
        ],[
            'id'        => '1',
            'name'      => 'Administrator',
        ]]);

        DB::statement('SET SESSION FOREIGN_KEY_CHECKS=1');
    }
}
