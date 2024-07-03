<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Package\Entities\Packagetype;
use DB;
class package_typesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //Packagetype::delete();
 
        Packagetype::create(array('title' => 'Economic'));
        Packagetype::create(array('title' => 'Delight'));
        Packagetype::create(array('title' => 'Luxary'));
        Packagetype::create(array('title' => 'Classic'));
    }
}
