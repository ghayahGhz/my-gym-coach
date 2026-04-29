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
            [
                'key' => 'bp',  'name' => 'بنش برس',
                'muscle' => 'chest',    'muscle_ar' => 'صدر',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=vcBig73ojpE',
            ],
            [
                'key' => 'df',  'name' => 'فلاي دمبل',
                'muscle' => 'chest',    'muscle_ar' => 'صدر',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=eozdVDA78K0',
            ],
            [
                'key' => 'pu',  'name' => 'تمرين الضغط',
                'muscle' => 'chest',    'muscle_ar' => 'صدر',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=IODxDxX7oi4',
            ],
            [
                'key' => 'cf',  'name' => 'كابل فلاي',
                'muscle' => 'chest',    'muscle_ar' => 'صدر',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=Iwe6AmxVf7o',
            ],
            // ───── ظهر (Back) ─────
            [
                'key' => 'lp',  'name' => 'لات بول داون',
                'muscle' => 'back',     'muscle_ar' => 'ظهر',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=CAwf7n6Luuc',
            ],
            [
                'key' => 'crw', 'name' => 'كابل رو',
                'muscle' => 'back',     'muscle_ar' => 'ظهر',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=GZbfZ033f74',
            ],
            [
                'key' => 'dl',  'name' => 'ديد ليفت',
                'muscle' => 'back',     'muscle_ar' => 'ظهر',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=op9kVnSso6Q',
            ],
            [
                'key' => 'puu', 'name' => 'عقلة',
                'muscle' => 'back',     'muscle_ar' => 'ظهر',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=eGo4IYlbE5g',
            ],
            // ───── أرجل (Legs) ─────
            [
                'key' => 'sq',  'name' => 'سكوات',
                'muscle' => 'legs',     'muscle_ar' => 'أرجل',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=gsNoPYwWXeM',
            ],
            [
                'key' => 'lpr', 'name' => 'ليج بريس',
                'muscle' => 'legs',     'muscle_ar' => 'أرجل',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=IZxyjW7MPJQ',
            ],
            [
                'key' => 'ht',  'name' => 'هيب ثرست',
                'muscle' => 'legs',     'muscle_ar' => 'أرجل',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=SEdqd1n0cvg',
            ],
            [
                'key' => 'lu',  'name' => 'لانج',
                'muscle' => 'legs',     'muscle_ar' => 'أرجل',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=QOVaHwm-Q6U',
            ],
            [
                'key' => 'rdl', 'name' => 'رومانيان ديد ليفت',
                'muscle' => 'legs',     'muscle_ar' => 'أرجل',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=JCXUYuzwNrM',
            ],
            [
                'key' => 'cal', 'name' => 'رفع الكعب',
                'muscle' => 'legs',     'muscle_ar' => 'أرجل',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=-M4-G8p1fCI',
            ],
            // ───── كتف (Shoulder) ─────
            [
                'key' => 'sp',  'name' => 'ضغط الكتف',
                'muscle' => 'shoulder', 'muscle_ar' => 'كتف',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=qEwKCR5JCog',
            ],
            [
                'key' => 'lr',  'name' => 'رفع جانبي',
                'muscle' => 'shoulder', 'muscle_ar' => 'كتف',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=3VcKaXpzqRo',
            ],
            [
                'key' => 'fr',  'name' => 'رفع أمامي',
                'muscle' => 'shoulder', 'muscle_ar' => 'كتف',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=sOoBQukXMFo',
            ],
            // ───── بطن (Abs) ─────
            [
                'key' => 'cru', 'name' => 'كرنش',
                'muscle' => 'abs',      'muscle_ar' => 'بطن',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=Xyd_fa5zoEU',
            ],
            [
                'key' => 'pl',  'name' => 'بلانك',
                'muscle' => 'abs',      'muscle_ar' => 'بطن',
                'category' => 'strength', 'is_time' => true,
                'youtube_url' => 'https://www.youtube.com/watch?v=pSHjTRCQxIw',
            ],
            [
                'key' => 'rt',  'name' => 'روسيان تويست',
                'muscle' => 'abs',      'muscle_ar' => 'بطن',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=wkD8rjkodUI',
            ],
            [
                'key' => 'hlr', 'name' => 'رفع الأرجل المعلقة',
                'muscle' => 'abs',      'muscle_ar' => 'بطن',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=hdng3Nm1x_E',
            ],
            [
                'key' => 'bc',  'name' => 'بايسيكل كرنش',
                'muscle' => 'abs',      'muscle_ar' => 'بطن',
                'category' => 'strength', 'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=9FGilxCbdz8',
            ],
            // ───── كارديو (Cardio) ─────
            [
                'key' => 'tm',  'name' => 'جهاز الجري',
                'muscle' => 'cardio',   'muscle_ar' => 'كارديو',
                'category' => 'cardio',   'is_time' => true,
                'youtube_url' => 'https://www.youtube.com/watch?v=kMMbqSCHPEA',
            ],
            [
                'key' => 'bh',  'name' => 'دراجة HIIT',
                'muscle' => 'cardio',   'muscle_ar' => 'كارديو',
                'category' => 'cardio',   'is_time' => true,
                'youtube_url' => 'https://www.youtube.com/watch?v=PqjpFWGf_5E',
            ],
            [
                'key' => 'scc', 'name' => 'ستير كلايمر',
                'muscle' => 'cardio',   'muscle_ar' => 'كارديو',
                'category' => 'cardio',   'is_time' => true,
                'youtube_url' => 'https://www.youtube.com/watch?v=n1GXCNtMB8o',
            ],
            [
                'key' => 'el',  'name' => 'إليبتيكال',
                'muscle' => 'cardio',   'muscle_ar' => 'كارديو',
                'category' => 'cardio',   'is_time' => true,
                'youtube_url' => 'https://www.youtube.com/watch?v=AsDzYuEv6V0',
            ],
            [
                'key' => 'ks',  'name' => 'تمرين الكيتل بيل',
                'muscle' => 'cardio',   'muscle_ar' => 'كارديو',
                'category' => 'cardio',   'is_time' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=sSESeQAir2M',
            ],
            // ───── إطالة (Stretch) ─────
            [
                'key' => 'bst', 'name' => 'إطالة الظهر',
                'muscle' => 'stretch',  'muscle_ar' => 'إطالة',
                'category' => 'stretch',  'is_time' => true,
                'youtube_url' => 'https://www.youtube.com/watch?v=g8M6oFWX5bU',
            ],
            [
                'key' => 'lst', 'name' => 'إطالة الأرجل',
                'muscle' => 'stretch',  'muscle_ar' => 'إطالة',
                'category' => 'stretch',  'is_time' => true,
                'youtube_url' => 'https://www.youtube.com/watch?v=_HDZODHx3TU',
            ],
            [
                'key' => 'sst', 'name' => 'إطالة الكتف',
                'muscle' => 'stretch',  'muscle_ar' => 'إطالة',
                'category' => 'stretch',  'is_time' => true,
                'youtube_url' => 'https://www.youtube.com/watch?v=8lDC4Ri9zAQ',
            ],
        ];

        foreach ($exercises as $ex) {
            Exercise::updateOrCreate(['key' => $ex['key']], $ex);
        }
    }
}
