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
            ],
            [
                'setting' => 'SOCIAL_FACEBOOK',
                'value' => 'https://fb.com/watheq'
            ],
            [
                'setting' => 'SOCIAL_TWITTER',
                'value' => 'https://twitter.com/watheq'
            ],
            [
                'setting' => 'SOCIAL_GOOGLE',
                'value' => 'https://plus.com/watheq'
            ]
        ]);
        $this->command->info('Settings seeded done!');
    }
}
