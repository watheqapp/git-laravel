<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class StaticPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('static_pages')->truncate();
        
        $termsContent = 'شروط الاستخدام';
        $helpContent = 'طريقة الاستخدام ';
        
        DB::table('static_pages')->insert([
            'page' => 'terms',
            'content' => $termsContent,
            'created_at' => date('Y-m-m H:i:s')
        ]);
        DB::table('static_pages')->insert([
            'page' => 'help',
            'content' => $helpContent,
            'created_at' => date('Y-m-m H:i:s')
        ]);
    }
}
