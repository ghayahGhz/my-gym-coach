<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            // ───── صدر (Chest) ─────
            ['key' => 'bp',  'name' => 'بنش برس',               'muscle' => 'chest',    'muscle_ar' => 'صدر',    'category' => 'strength', 'is_time' => false],
            ['key' => 'df',  'name' => 'فلاي دمبل',             'muscle' => 'chest',    'muscle_ar' => 'صدر',    'category' => 'strength', 'is_time' => false],
            ['key' => 'pu',  'name' => 'تمرين الضغط',           'muscle' => 'chest',    'muscle_ar' => 'صدر',    'category' => 'strength', 'is_time' => false],
            ['key' => 'cf',  'name' => 'كابل فلاي',             'muscle' => 'chest',    'muscle_ar' => 'صدر',    'category' => 'strength', 'is_time' => false],
            // ───── ظهر (Back) ─────
            ['key' => 'lp',  'name' => 'لات بول داون',          'muscle' => 'back',     'muscle_ar' => 'ظهر',    'category' => 'strength', 'is_time' => false],
            ['key' => 'crw', 'name' => 'كابل رو',               'muscle' => 'back',     'muscle_ar' => 'ظهر',    'category' => 'strength', 'is_time' => false],
            ['key' => 'dl',  'name' => 'ديد ليفت',              'muscle' => 'back',     'muscle_ar' => 'ظهر',    'category' => 'strength', 'is_time' => false],
            ['key' => 'puu', 'name' => 'عقلة',                  'muscle' => 'back',     'muscle_ar' => 'ظهر',    'category' => 'strength', 'is_time' => false],
            // ───── أرجل (Legs) ─────
            ['key' => 'sq',  'name' => 'سكوات',                 'muscle' => 'legs',     'muscle_ar' => 'أرجل',   'category' => 'strength', 'is_time' => false],
            ['key' => 'lpr', 'name' => 'ليج بريس',              'muscle' => 'legs',     'muscle_ar' => 'أرجل',   'category' => 'strength', 'is_time' => false],
            ['key' => 'ht',  'name' => 'هيب ثرست',              'muscle' => 'legs',     'muscle_ar' => 'أرجل',   'category' => 'strength', 'is_time' => false],
            ['key' => 'lu',  'name' => 'لانج',                  'muscle' => 'legs',     'muscle_ar' => 'أرجل',   'category' => 'strength', 'is_time' => false],
            ['key' => 'rdl', 'name' => 'رومانيان ديد ليفت',    'muscle' => 'legs',     'muscle_ar' => 'أرجل',   'category' => 'strength', 'is_time' => false],
            ['key' => 'cal', 'name' => 'رفع الكعب',             'muscle' => 'legs',     'muscle_ar' => 'أرجل',   'category' => 'strength', 'is_time' => false],
            // ───── كتف (Shoulder) ─────
            ['key' => 'sp',  'name' => 'ضغط الكتف',             'muscle' => 'shoulder', 'muscle_ar' => 'كتف',    'category' => 'strength', 'is_time' => false],
            ['key' => 'lr',  'name' => 'رفع جانبي',             'muscle' => 'shoulder', 'muscle_ar' => 'كتف',    'category' => 'strength', 'is_time' => false],
            ['key' => 'fr',  'name' => 'رفع أمامي',             'muscle' => 'shoulder', 'muscle_ar' => 'كتف',    'category' => 'strength', 'is_time' => false],
            // ───── بطن (Abs) ─────
            ['key' => 'cru', 'name' => 'كرنش',                  'muscle' => 'abs',      'muscle_ar' => 'بطن',    'category' => 'strength', 'is_time' => false],
            ['key' => 'pl',  'name' => 'بلانك',                 'muscle' => 'abs',      'muscle_ar' => 'بطن',    'category' => 'strength', 'is_time' => true],
            ['key' => 'rt',  'name' => 'روسيان تويست',          'muscle' => 'abs',      'muscle_ar' => 'بطن',    'category' => 'strength', 'is_time' => false],
            ['key' => 'hlr', 'name' => 'رفع الأرجل المعلقة',   'muscle' => 'abs',      'muscle_ar' => 'بطن',    'category' => 'strength', 'is_time' => false],
            ['key' => 'bc',  'name' => 'بايسيكل كرنش',          'muscle' => 'abs',      'muscle_ar' => 'بطن',    'category' => 'strength', 'is_time' => false],
            // ───── كارديو (Cardio) ─────
            ['key' => 'tm',  'name' => 'جهاز الجري',            'muscle' => 'cardio',   'muscle_ar' => 'كارديو', 'category' => 'cardio',   'is_time' => true],
            ['key' => 'bh',  'name' => 'دراجة HIIT',            'muscle' => 'cardio',   'muscle_ar' => 'كارديو', 'category' => 'cardio',   'is_time' => true],
            ['key' => 'scc', 'name' => 'ستير كلايمر',           'muscle' => 'cardio',   'muscle_ar' => 'كارديو', 'category' => 'cardio',   'is_time' => true],
            ['key' => 'el',  'name' => 'إليبتيكال',             'muscle' => 'cardio',   'muscle_ar' => 'كارديو', 'category' => 'cardio',   'is_time' => true],
            ['key' => 'ks',  'name' => 'تمرين الكيتل بيل',      'muscle' => 'cardio',   'muscle_ar' => 'كارديو', 'category' => 'cardio',   'is_time' => false],
            // ───── إطالة (Stretch) ─────
            ['key' => 'bst', 'name' => 'إطالة الظهر',           'muscle' => 'stretch',  'muscle_ar' => 'إطالة',  'category' => 'stretch',  'is_time' => true],
            ['key' => 'lst', 'name' => 'إطالة الأرجل',          'muscle' => 'stretch',  'muscle_ar' => 'إطالة',  'category' => 'stretch',  'is_time' => true],
            ['key' => 'sst', 'name' => 'إطالة الكتف',           'muscle' => 'stretch',  'muscle_ar' => 'إطالة',  'category' => 'stretch',  'is_time' => true],
        ];

        foreach ($exercises as $ex) {
            Exercise::updateOrCreate(['key' => $ex['key']], $ex);
        }
    }
}

