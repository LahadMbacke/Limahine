<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publication;
use App\Models\FilsCheikh;
use App\Models\User;

class PublicationDecouverteSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $filsCheikhs = FilsCheikh::all();

        $publications = [
            [
                'title' => [
                    'fr' => 'La Vision Spirituelle de Serigne Moustapha Mbacké',
                    'en' => 'The Spiritual Vision of Serigne Moustapha Mbacké',
                    'ar' => 'الرؤية الروحية للشيخ مصطفى مباكي'
                ],
                'content' => [
                    'fr' => '<p>Serigne Moustapha Mbacké, deuxième Khalife général des Mourides, a marqué l\'histoire de la confrérie par sa vision spirituelle profonde et ses contributions poétiques remarquables.</p><p>Son approche de l\'enseignement spirituel alliant tradition et modernité a permis à la communauté mouride de s\'adapter aux défis de son époque tout en préservant l\'authenticité des enseignements fondateurs.</p>',
                    'en' => '<p>Serigne Moustapha Mbacké, second Khalif General of the Mourides, marked the history of the brotherhood through his profound spiritual vision and remarkable poetic contributions.</p><p>His approach to spiritual teaching combining tradition and modernity allowed the Mouride community to adapt to the challenges of his time while preserving the authenticity of the founding teachings.</p>',
                    'ar' => '<p>الشيخ مصطفى مباكي، الخليفة العام الثاني للمريدين، طبع تاريخ الطريقة برؤيته الروحية العميقة ومساهماته الشعرية الرائعة.</p><p>نهجه في التعليم الروحي الذي يجمع بين التقليد والحداثة مكّن الجماعة المريدية من التكيف مع تحديات عصره مع الحفاظ على أصالة التعاليم المؤسسة.</p>'
                ],
                'excerpt' => [
                    'fr' => 'Découvrez la vision spirituelle unique du deuxième Khalife général des Mourides et son impact sur la communauté.',
                    'en' => 'Discover the unique spiritual vision of the second Khalif General of the Mourides and its impact on the community.',
                    'ar' => 'اكتشف الرؤية الروحية الفريدة للخليفة العام الثاني للمريدين وتأثيرها على الجماعة.'
                ],
                'slug' => 'vision-spirituelle-serigne-moustapha-mbacke',
                'category' => 'decouverte',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'reading_time' => 8,
                'fils_cheikh_id' => $filsCheikhs->where('slug', 'serigne-moustapha-mbacke')->first()?->id,
            ],
            [
                'title' => [
                    'fr' => 'L\'Héritage Architectural de Serigne Mamadou Moustapha',
                    'en' => 'The Architectural Legacy of Serigne Mamadou Moustapha',
                    'ar' => 'الإرث المعماري للشيخ محمدو مصطفى'
                ],
                'content' => [
                    'fr' => '<p>Serigne Mamadou Moustapha Mbacké a révolutionné l\'urbanisme de Touba en y introduisant des concepts modernes tout en respectant l\'esprit spirituel du lieu.</p><p>Ses projets de développement urbain ont fait de Touba une ville moderne capable d\'accueillir des millions de pèlerins lors du Grand Magal, tout en préservant son caractère sacré.</p>',
                    'en' => '<p>Serigne Mamadou Moustapha Mbacké revolutionized the urban planning of Touba by introducing modern concepts while respecting the spiritual essence of the place.</p><p>His urban development projects made Touba a modern city capable of hosting millions of pilgrims during the Grand Magal, while preserving its sacred character.</p>',
                    'ar' => '<p>الشيخ محمدو مصطفى مباكي ثوّر التخطيط العمراني لطوبى بإدخال مفاهيم حديثة مع احترام الروح الروحية للمكان.</p><p>مشاريعه للتطوير العمراني جعلت من طوبى مدينة حديثة قادرة على استيعاب ملايين الحجاج خلال المولد الكبير، مع الحفاظ على طابعها المقدس.</p>'
                ],
                'excerpt' => [
                    'fr' => 'Explorez comment le troisième Khalife a transformé Touba en une métropole moderne tout en préservant son essence spirituelle.',
                    'en' => 'Explore how the third Khalif transformed Touba into a modern metropolis while preserving its spiritual essence.',
                    'ar' => 'استكشف كيف حوّل الخليفة الثالث طوبى إلى متروبول حديث مع الحفاظ على جوهرها الروحي.'
                ],
                'slug' => 'heritage-architectural-serigne-mamadou-moustapha',
                'category' => 'decouverte',
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'reading_time' => 12,
                'fils_cheikh_id' => $filsCheikhs->where('slug', 'serigne-mamadou-moustapha-mbacke')->first()?->id,
            ],
            [
                'title' => [
                    'fr' => 'Serigne Abdoul Ahad et la Révolution Agricole Mouride',
                    'en' => 'Serigne Abdoul Ahad and the Mouride Agricultural Revolution',
                    'ar' => 'الشيخ عبد الأحد والثورة الزراعية المريدية'
                ],
                'content' => [
                    'fr' => '<p>Sous la direction de Serigne Abdoul Ahad Mbacké, la communauté mouride a connu une véritable révolution agricole qui a transformé le paysage économique du Sénégal.</p><p>Son encouragement à l\'agriculture intensive et à l\'innovation agricole a permis aux mourides de devenir des acteurs majeurs de l\'économie sénégalaise, incarnant parfaitement la philosophie du travail prônée par Cheikh Ahmadou Bamba.</p>',
                    'en' => '<p>Under the leadership of Serigne Abdoul Ahad Mbacké, the Mouride community experienced a true agricultural revolution that transformed the economic landscape of Senegal.</p><p>His encouragement of intensive agriculture and agricultural innovation allowed the Mourides to become major players in the Senegalese economy, perfectly embodying the work philosophy advocated by Cheikh Ahmadou Bamba.</p>',
                    'ar' => '<p>تحت قيادة الشيخ عبد الأحد مباكي، شهدت الجماعة المريدية ثورة زراعية حقيقية حولت المشهد الاقتصادي للسنغال.</p><p>تشجيعه للزراعة المكثفة والابتكار الزراعي مكّن المريدين من أن يصبحوا فاعلين رئيسيين في الاقتصاد السنغالي، مجسدين بشكل مثالي فلسفة العمل التي نادى بها الشيخ أحمدو بامبا.</p>'
                ],
                'excerpt' => [
                    'fr' => 'Découvrez comment le quatrième Khalife a révolutionné l\'agriculture sénégalaise en s\'appuyant sur les enseignements de Cheikh Ahmadou Bamba.',
                    'en' => 'Discover how the fourth Khalif revolutionized Senegalese agriculture based on the teachings of Cheikh Ahmadou Bamba.',
                    'ar' => 'اكتشف كيف ثوّر الخليفة الرابع الزراعة السنغالية بناءً على تعاليم الشيخ أحمدو بامبا.'
                ],
                'slug' => 'serigne-abdoul-ahad-revolution-agricole',
                'category' => 'decouverte',
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'reading_time' => 10,
                'fils_cheikh_id' => $filsCheikhs->where('slug', 'serigne-abdoul-ahad-mbacke')->first()?->id,
            ]
        ];

        foreach ($publications as $pubData) {
            Publication::create(array_merge($pubData, [
                'author_id' => $user->id,
                'featured' => false,
                'tags' => ['découverte', 'histoire', 'mouridisme']
            ]));
        }
    }
}
