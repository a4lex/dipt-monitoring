<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create Empty and Admin role
        $this->call(RolesSeeder::class);

        // create super_admin id:0 and admin id:1
        $this->call(UsersTableSeeder::class);

        // create default domain for super_admin - 127.0.0.1
        $this->call(DomainsTableSeeder::class);

        // fill example of represent model
        $this->call(RepresentsSeeder::class);
    }
}
