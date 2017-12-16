<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('permissions')->truncate();

        $permission = [
            [
                'name' => 'role-employee',
                'description' => 'Manage employee operations',
                'module' => 'employee'
            ],
            
            [
                'name' => 'role-client',
                'description' => 'Manage client operations',
                'module' => 'client'
            ],
            
            [
                'name' => 'role-lawyer',
                'description' => 'Manage lawyer operations',
                'module' => 'lawyer'
            ],
            
            [
                'name' => 'role-role',
                'description' => 'Manage roles operations',
                'module' => 'role'
            ],
           

        ];

        foreach ($permission as $key => $value) {
            \App\Permission::create($value);
        }
        
        $this->command->info('Permissions seeded done!');

    }

}
