<?php

use Illuminate\Database\Seeder;

class RepresentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Dumping data for table `column_types`
        DB::statement("INSERT INTO `column_types` VALUES " .
            "(1,'TextField','represent.elements.text')," .
            "(2,'Dropdown','represent.elements.dropdown')," .
            "(3,'Boolean','represent.elements.boolean')," .
            "(4,'ItemLink','represent.elements.item-link')," .
            "(5,'Password','represent.elements.password')," .
            "(6,'DateTime','represent.elements.datetime')," .
            "(7,'Date','represent.elements.date')," .
            "(8,'Time','represent.elements.time')" .
            ";");
//
//        //Dumping data for table `models`
//        DB::statement("INSERT INTO `models` VALUES " .
//            "(1,'users','Users','users','u1','id','name','App\\\User','UserController')," .
//            "(2,'roles','Roles','roles','r1','id','name','App\\\Role','RoleController')" .
//            ";");
//
//        //Dumping data for table `columns`
//        DB::statement("INSERT INTO `columns` VALUES " .
//            "(1,1,1,'u1.id','id','#','','',1,1,0,1,'text-center','string')," .
//            "(2,1,4,'u1.name','name','Display Name','Def value','',2,0,1,1,'text-center','string')," .
//            "(3,1,1,'u1.email','email','EMail','myname@mail.com','',3,1,1,1,'text-center','string|email')," .
//            "(4,1,2,'u1.parent_id','parent_id','Parent ID','@auth_id','@users',4,0,1,0,'text-center','string')," .
//            "(5,1,2,'u1.role_id','role_id','Group','','@roles',4,0,1,0,'text-center','string')," .
//            "(6,1,1,'CONCAT(d1.name)','domain','Domain','','',1,0,0,1,'text-center','')," .
//            "(7,1,5,'u1.id','password','Password','','',1,0,1,1,'text-center','string|min:8|confirmed')," .
//            "(10,2,1,'r1.id','id','#','','',1,1,0,1,'text-center','string')," .
//            "(11,2,1,'r1.name','name','Name','','',2,0,1,1,'text-center','string')" .
//            ";");
//
//        //Dumping data for table `joins`
//        DB::statement("INSERT INTO `joins` VALUES " .
//            "(1,1,'left','domains','d1','u1.id','d1.user_id','=')" .
//            ";");
//
//        //Dumping data for table `actions`
//        DB::statement("INSERT INTO `actions` VALUES " .
//            "(1,1,1,'delete',1),(2,1,1,'edit',1),(3,1,1,'create',1),(4,1,1,'view',1)," .
//            "(5,2,1,'delete',1),(6,2,1,'edit',1),(7,2,1,'create',1),(8,2,1,'view',1)" .
//            ";");

    }
}
