<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();
        DB::table('settings')->insert([
            [
                'setting' => 'DELIVER_REQUEST_TO_HOME',
                'value' => 150
            ]
        ]);
        $this->command->info('Settings seeded done!');
    }
}
