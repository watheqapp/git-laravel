<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'WatheqAdmin',
            'email' => 'admin@watheq.com',
            'phone' => '966504422775',
            'password' => bcrypt('watheq123'),
            'admin' => true,
            'type' => \App\User::$BACKEND_TYPE,
            'created_at' => date('Y-m-m H:i:s')
        ]);
        $this->command->info('Users seeded done!'); 
    }
}
