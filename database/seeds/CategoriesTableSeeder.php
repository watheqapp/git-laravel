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
                'nameAr' => 'الوكالات',
                'nameEn' => 'Authorization',
                'descriptionAr' => 'إنشاء أو فسخ وكالة',
                'descriptionEn' => 'Create or terminate an authorization',
                'leave' => false,
                'parent' => NULL,
                'cost' =>0,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // ----------------------اصناف الوكالات---------------------------
            [
                'id' => '2',
                'nameAr' => 'انشاء وكالة',
                'nameEn' => 'Setup authorization',
                'descriptionAr' => '',
                'descriptionEn' => '',
                'leave' => false,
                'parent' => 1,
                'cost' =>0,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // ----------------------اصناف انشاء الوكلات---------------------------
            [
                'id' => '3',
                'nameAr' => 'فرد',
                'nameEn' => 'Individual ',
                'descriptionAr' => 'بصفته فرد',
                'descriptionEn' => 'Individual authorization',
                'leave' => true,
                'parent' => 2,
                'cost' => 10,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '4',
                'nameAr' => 'مؤسسة',
                'nameEn' => 'Institution',
                'descriptionAr' => 'بصفته مدير او مالك مؤسسه',
                'descriptionEn' => 'As a manager of owner of the institution',
                'leave' => true,
                'parent' => 2,
                'cost' => 50,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '5',
                'nameAr' => 'شركة',
                'nameEn' => 'Company',
                'descriptionAr' => 'بصفته مدير او شريك شركه',
                'descriptionEn' => 'As the manager of owner of the company',
                'leave' => true,
                'parent' => 2,
                'cost' => 100,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // ----------------------اصناف فسخ الوكلات---------------------------
            [
                'id' => '6',
                'nameAr' => 'فسخ وكالة',
                'nameEn' => 'Cancel authorization',
                'descriptionAr' => 'فسخ أو إلغاء',
                'descriptionEn' => 'Cancelation of authorization',
                'leave' => false,
                'parent' => 1,
                'cost' =>0,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '7',
                'nameAr' => 'فرد',
                'nameEn' => 'Individual ',
                'descriptionAr' => 'توكيل بصفته فرد',
                'descriptionEn' => 'Individual authorization',
                'leave' => true,
                'parent' => 6,
                'cost' => 15,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '8',
                'nameAr' => 'مؤسسة',
                'nameEn' => 'Institution',
                'descriptionAr' => 'بصفته صاحب أو شريك أو مدير المؤسسة',
                'descriptionEn' => 'As a manager of owner of the institution',
                'leave' => true,
                'parent' => 6,
                'cost' => 75,
                'created_at' => date('Y-m-m H:i:s')
            ],
            [
                'id' => '9',
                'nameAr' => 'فسخ وكالة ل شركة',
                'nameEn' => 'Cancel power of attorney for Company',
                'descriptionAr' => 'بصفته صاحب أو شريك أو مدير الشركة',
                'descriptionEn' => 'As the manager of owner of the company',
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
                'descriptionAr' => '',
                'descriptionEn' => '',
                'leave' => true,
                'parent' => NULL,
                'cost' => 600,
                'created_at' => date('Y-m-m H:i:s')
            ],
            // ---------------------اصناف تصديق عقد---------------------------
            // [
            //     'id' => '11',
            //     'nameAr' => 'تصديق عقود تأسيس الشركات ',
            //     'nameEn' => 'Validation of company establishment',
            //     'descriptionAr' => 'أو توثيق القرارات الصادرة منها',
            //     'descriptionEn' => 'Or stamping their contracts',
            //     'leave' => true,
            //     'parent' => 10,
            //     'cost' => 600,
            //     'created_at' => date('Y-m-m H:i:s')
            // ],
//            [
//                'id' => '12',
//                'nameAr' => 'لا داعي لها',
//                'nameEn' => 'Validate of company contract',
//                'descriptionAr' => '',
//                'descriptionEn' => '',
//                'leave' => true,
//                'parent' => 10,
//                'cost' => 200,
//                'created_at' => date('Y-m-m H:i:s')
//            ],
            // --------------------- عقد زواج---------------------------
            [
                'id' => '13',
                'nameAr' => ' عقد زواج',
                'nameEn' => 'Marriage contract',
                'descriptionAr' => 'عقود النكاح والطلاق',
                'descriptionEn' => 'Marriage and divorce contracts',
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
