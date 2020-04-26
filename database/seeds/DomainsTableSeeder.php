<?php

use Illuminate\Database\Seeder;

class DomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('domains')->insert([[
            'id'        => '1',
            'user_id'   => '1',
            'name'      => '127.0.0.1',
            'created_at'=> 'NOW()',
            'updated_at'=> 'NOW()'
        ]]);
    }
}
