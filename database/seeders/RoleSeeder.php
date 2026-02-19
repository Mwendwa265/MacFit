<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {
        Role::create([
            'name'=>'Admin',
            'description'=>''
           

        ]);

         Role::create([
            'name'=>'secretary',
            'description'=>'to check the Users records'
          

         ]);

          Role::create([
            'name'=>'User',
            'description'=>'To work out'
           
            

         ]);
       
          Role::create([
            'name'=>'staff',
            'description'=>'To clean up'

         ]);
       
       
       
    }
}
