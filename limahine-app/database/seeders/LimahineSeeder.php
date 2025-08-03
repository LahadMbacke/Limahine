<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Publication;
use App\Models\Temoignage;
use App\Models\Bibliographie;
use App\Models\Page;

class LimahineSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un utilisateur admin
        $admin = User::firstOrCreate([
            'email' => 'admin@limahine.com'
        ], [
            'name' => 'Administrateur Limahine',
            'password' => bcrypt('password')
        ]);

        // Créer des publications
        $publications = [
            [
                'title' => [
                    'fr' => 'Les fondements spirituels du Mouridisme',
                    'en' => 'The Spiritual Foundations of Mouridism',
                    'ar' => 'الأسس الروحية للطريقة المريدية'
                ],
                'content' => [
                    'fr' => '<p>Le mouridisme, fondé par Cheikh Ahmadou Bamba Mbacké, représente une voie spirituelle unique dans l\'Islam soufi...</p>',
                    'en' => '<p>Mouridism, founded by Cheikh Ahmadou Bamba Mbacké, represents a unique spiritual path in Sufi Islam...</p>',
                    'ar' => '<p>الطريقة المريدية التي أسسها الشيخ أحمدو بمب إمباكي تمثل طريقا روحيا فريدا في الإسلام الصوفي...</p>'
                ],
                'excerpt' => [
                    'fr' => 'Découvrez les principes fondamentaux qui guident la voie mouride.',
                    'en' => 'Discover the fundamental principles that guide the Mouride path.',
                    'ar' => 'اكتشف المبادئ الأساسية التي توجه الطريقة المريدية'
                ],
                'category' => 'tasawwuf',
                'slug' => 'fondements-spirituels-mouridisme',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'featured' => true,
                'reading_time' => 8
            ],
            [
                'title' => [
                    'fr' => 'L\'éducation selon Cheikh Ahmadou Bamba',
                    'en' => 'Education according to Cheikh Ahmadou Bamba',
                    'ar' => 'التعليم وفقاً للشيخ أحمدو بمب'
                ],
                'content' => [
                    'fr' => '<p>L\'approche éducative de Cheikh Ahmadou Bamba mettait l\'accent sur l\'alliance entre savoir séculier et spirituel...</p>',
                    'en' => '<p>Cheikh Ahmadou Bamba\'s educational approach emphasized the alliance between secular and spiritual knowledge...</p>',
                    'ar' => '<p>منهج الشيخ أحمدو بمب التعليمي أكد على التحالف بين المعرفة الدنيوية والروحية...</p>'
                ],
                'excerpt' => [
                    'fr' => 'L\'approche révolutionnaire de l\'éducation prônée par le guide spirituel.',
                    'en' => 'The revolutionary approach to education advocated by the spiritual guide.',
                    'ar' => 'النهج الثوري للتعليم الذي دعا إليه المرشد الروحي'
                ],
                'category' => 'philosophy',
                'slug' => 'education-cheikh-ahmadou-bamba',
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'featured' => false,
                'reading_time' => 6
            ],
            [
                'title' => [
                    'fr' => 'Les Khassaïds : Poésie spirituelle et enseignements',
                    'en' => 'The Qasidas: Spiritual Poetry and Teachings',
                    'ar' => 'القصائد: الشعر الروحي والتعاليم'
                ],
                'content' => [
                    'fr' => '<p>Les Khassaïds de Cheikh Ahmadou Bamba constituent un patrimoine littéraire et spirituel exceptionnel...</p>',
                    'en' => '<p>The Qasidas of Cheikh Ahmadou Bamba constitute an exceptional literary and spiritual heritage...</p>',
                    'ar' => '<p>قصائد الشيخ أحمدو بمب تشكل تراثاً أدبياً وروحياً استثنائياً...</p>'
                ],
                'excerpt' => [
                    'fr' => 'Exploration des poèmes spirituels du fondateur du mouridisme.',
                    'en' => 'Exploration of the spiritual poems of the founder of Mouridism.',
                    'ar' => 'استكشاف القصائد الروحية لمؤسس الطريقة المريدية'
                ],
                'category' => 'khassaids',
                'slug' => 'khassaids-poesie-spirituelle',
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'featured' => true,
                'reading_time' => 12
            ]
        ];

        foreach ($publications as $pubData) {
            Publication::create(array_merge($pubData, ['author_id' => $admin->id]));
        }

        // Créer des témoignages
        $temoignages = [
            [
                'title' => [
                    'fr' => 'La baraka de Cheikh Ahmadou Bamba',
                    'en' => 'The baraka of Cheikh Ahmadou Bamba',
                    'ar' => 'بركة الشيخ أحمدو بمب'
                ],
                'content' => [
                    'fr' => '<p>J\'ai été témoin de nombreux prodiges attribués à la baraka de Cheikh Ahmadou Bamba...</p>',
                    'en' => '<p>I witnessed many miracles attributed to the baraka of Cheikh Ahmadou Bamba...</p>',
                    'ar' => '<p>شهدت العديد من الكرامات المنسوبة إلى بركة الشيخ أحمدو بمب...</p>'
                ],
                'author_name' => 'El Hadj Mbacké Diop',
                'author_title' => [
                    'fr' => 'Disciple et compagnon',
                    'en' => 'Disciple and companion',
                    'ar' => 'تلميذ ورفيق'
                ],
                'author_description' => [
                    'fr' => 'Compagnon fidèle de Cheikh Ahmadou Bamba pendant plus de 30 ans.',
                    'en' => 'Faithful companion of Cheikh Ahmadou Bamba for more than 30 years.',
                    'ar' => 'رفيق مخلص للشيخ أحمدو بمب لأكثر من 30 عاماً'
                ],
                'location' => 'Touba',
                'date_temoignage' => '1920-03-15',
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'featured' => true,
                'verified' => true
            ]
        ];

        foreach ($temoignages as $temoignageData) {
            Temoignage::create($temoignageData);
        }

        // Créer des entrées bibliographiques
        $bibliographies = [
            [
                'title' => [
                    'fr' => 'Masâlik al-Jinân',
                    'en' => 'Masalik al-Jinan',
                    'ar' => 'مسالك الجنان'
                ],
                'author_name' => [
                    'fr' => 'Cheikh Ahmadou Bamba Mbacké',
                    'en' => 'Cheikh Ahmadou Bamba Mbacké',
                    'ar' => 'الشيخ أحمدو بمب إمباكي'
                ],
                'description' => [
                    'fr' => 'Chef-d\'œuvre de littérature spirituelle traitant du voyage de l\'âme vers Dieu.',
                    'en' => 'Masterpiece of spiritual literature dealing with the soul\'s journey to God.',
                    'ar' => 'تحفة من الأدب الروحي تتناول رحلة الروح إلى الله'
                ],
                'type' => 'livre',
                'langue' => 'Arabe',
                'date_publication' => '1895-01-01',
                'category' => 'cheikh_ahmadou_bamba',
                'is_published' => true,
                'featured' => true,
                'disponible_en_ligne' => true
            ]
        ];

        foreach ($bibliographies as $bibData) {
            Bibliographie::create($bibData);
        }

        // Créer des pages
        $pages = [
            [
                'title' => [
                    'fr' => 'Notre Philosophie',
                    'en' => 'Our Philosophy',
                    'ar' => 'فلسفتنا'
                ],
                'slug' => 'philosophie',
                'content' => [
                    'fr' => '<p>La philosophie de Limahine s\'ancre dans les enseignements de Cheikh Ahmadou Bamba...</p>',
                    'en' => '<p>Limahine\'s philosophy is rooted in the teachings of Cheikh Ahmadou Bamba...</p>',
                    'ar' => '<p>فلسفة لماحين متجذرة في تعاليم الشيخ أحمدو بمب...</p>'
                ],
                'excerpt' => [
                    'fr' => 'Découvrez les valeurs qui nous guident.',
                    'en' => 'Discover the values that guide us.',
                    'ar' => 'اكتشف القيم التي توجهنا'
                ],
                'page_type' => 'philosophy',
                'is_published' => true
            ]
        ];

        foreach ($pages as $pageData) {
            Page::create($pageData);
        }
    }
}
