<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('categories')->truncate();

        $categories = [
            // ----------------------وكالات---------------------------
            [
                'id' => '1',
                'nameAr' => 'وكالات',
                'nameEn' => 'Powers of attorney',
                'leave' => false,
                'parent' => NULL,
                'cost' =>0,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // ----------------------اصناف الوكالات---------------------------
            [
                'id' => '2',
                'nameAr' => 'انشاء وكالة',
                'nameEn' => 'Set-up power of attorney',
                'leave' => false,
                'parent' => 1,
                'cost' =>0,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // ----------------------اصناف انشاء الوكلات---------------------------
            [
                'id' => '3',
                'nameAr' => 'انشاء وكالة فرد',
                'nameEn' => 'Set-up power of attorney for Individual ',
                'leave' => true,
                'parent' => 2,
                'cost' => 10,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '4',
                'nameAr' => 'انشاء وكالة ل مؤسسة',
                'nameEn' => 'Set-up power of attorney  for Institution',
                'leave' => true,
                'parent' => 2,
                'cost' => 50,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '5',
                'nameAr' => 'انشاء وكالة ل شركة',
                'nameEn' => 'Set-up power of attorney  for Company',
                'leave' => true,
                'parent' => 2,
                'cost' => 100,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // ----------------------اصناف فسخ الوكلات---------------------------
            [
                'id' => '6',
                'nameAr' => 'فسخ وكالة',
                'nameEn' => 'Cancel power of attorney',
                'leave' => false,
                'parent' => 1,
                'cost' =>0,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '7',
                'nameAr' => 'فسخ وكالة فرد',
                'nameEn' => 'Set-up power of attorney for Individual ',
                'leave' => true,
                'parent' => 6,
                'cost' => 15,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '8',
                'nameAr' => ' فسخ وكالة ل مؤسسة',
                'nameEn' => 'Cancel power of attorney for Institution',
                'leave' => true,
                'parent' => 6,
                'cost' => 75,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '9',
                'nameAr' => 'فسخ وكالة ل شركة',
                'nameEn' => 'Cancel power of attorney for Company',
                'leave' => true,
                'parent' => 6,
                'cost' => 125,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // ----------------------تصديق عقد---------------------------
            [
                'id' => '10',
                'nameAr' => 'تصديق عقد',
                'nameEn' => 'Validate the contract',
                'leave' => false,
                'parent' => NULL,
                'cost' =>0,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // ---------------------اصناف تصديق عقد---------------------------
            [
                'id' => '11',
                'nameAr' => 'تصديق عقد تأسيس شركة ',
                'nameEn' => 'validation of company establish contract',
                'leave' => true,
                'parent' => 10,
                'cost' => 600,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '12',
                'nameAr' => 'تصديق عقد',
                'nameEn' => 'Validate of company contract',
                'leave' => true,
                'parent' => 10,
                'cost' => 200,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // --------------------- عقد زواج---------------------------
            [
                'id' => '13',
                'nameAr' => ' عقد زواج',
                'nameEn' => 'Marriage contract',
                'leave' => true,
                'parent' => NULL,
                'cost' => 400,
                'created_at' => date('Y-m-m H:i:s')
            ],
        ];

        DB::table('categories')->insert($categories);
        $this->command->info('Categories seeded done!');
    }

}
