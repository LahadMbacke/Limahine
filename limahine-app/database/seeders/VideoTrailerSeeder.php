<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VideoTrailer;
use Illuminate\Support\Str;

class VideoTrailerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer les données existantes pour éviter les doublons
        VideoTrailer::truncate();

        $trailers = [
            [
                'title' => [
                    'fr' => 'Les Fondements du Taṣawwuf selon Cheikh Ahmadou Bamba',
                    'en' => 'The Foundations of Tasawwuf according to Sheikh Ahmadou Bamba',
                    'ar' => 'أسس التصوف عند الشيخ أحمدو بامبا'
                ],
                'description' => [
                    'fr' => 'Une introduction aux principes fondamentaux de l\'éducation spirituelle dans la voie mouride.',
                    'en' => 'An introduction to the fundamental principles of spiritual education in the Mouride way.',
                    'ar' => 'مقدمة في المبادئ الأساسية للتعليم الروحي في الطريقة المريدية'
                ],
                'youtube_video_id' => 'dQw4w9WgXcQ', // ID YouTube valide pour test
                'youtube_original_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'start_time' => 0,
                'end_time' => 30,
                'trailer_duration' => 30,
                'category' => 'tasawwuf',
                'featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'tags' => ['tasawwuf', 'spiritualité', 'mouridisme'],
                'slug' => 'fondements-tasawwuf-cheikh-ahmadou-bamba'
            ],
            [
                'title' => [
                    'fr' => 'Enseignements sur le Fiqh - Jurisprudence Islamique',
                    'en' => 'Teachings on Fiqh - Islamic Jurisprudence',
                    'ar' => 'تعاليم في الفقه - الفقه الإسلامي'
                ],
                'description' => [
                    'fr' => 'Les règles de jurisprudence islamique selon l\'école de pensée de Cheikh Ahmadou Bamba.',
                    'en' => 'The rules of Islamic jurisprudence according to the school of thought of Sheikh Ahmadou Bamba.',
                    'ar' => 'قواعد الفقه الإسلامي حسب مدرسة الشيخ أحمدو بامبا'
                ],
                'youtube_video_id' => 'jNQXAC9IVRw', // ID YouTube valide pour test
                'youtube_original_url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
                'start_time' => 0,
                'end_time' => 45,
                'trailer_duration' => 45,
                'category' => 'fiqh',
                'featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(1),
                'tags' => ['fiqh', 'jurisprudence', 'islam'],
                'slug' => 'enseignements-fiqh-jurisprudence-islamique'
            ],
            [
                'title' => [
                    'fr' => 'La Sîra du Prophète Muhammad ﷺ - Épisode 1',
                    'en' => 'The Sira of Prophet Muhammad ﷺ - Episode 1',
                    'ar' => 'سيرة النبي محمد ﷺ - الحلقة الأولى'
                ],
                'description' => [
                    'fr' => 'Première partie de l\'étude de la biographie prophétique selon les enseignements mourides.',
                    'en' => 'First part of the study of the prophetic biography according to Mouride teachings.',
                    'ar' => 'الجزء الأول من دراسة السيرة النبوية وفقا للتعاليم المريدية'
                ],
                'youtube_video_id' => '9bZkp7q19f0', // ID YouTube valide pour test
                'youtube_original_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'start_time' => 0,
                'end_time' => 60,
                'trailer_duration' => 60,
                'category' => 'sira',
                'featured' => true,
                'is_published' => true,
                'published_at' => now()->subHours(12),
                'tags' => ['sira', 'prophète', 'biographie'],
                'slug' => 'sira-prophete-muhammad-episode-1'
            ],
            [
                'title' => [
                    'fr' => 'Khassaïd : Poésie Spirituelle de Cheikh Ahmadou Bamba',
                    'en' => 'Khassaid: Spiritual Poetry of Sheikh Ahmadou Bamba',
                    'ar' => 'القصائد: الشعر الروحي للشيخ أحمدو بامبا'
                ],
                'description' => [
                    'fr' => 'Découverte des poèmes spirituels et de leur signification profonde dans la tradition mouride.',
                    'en' => 'Discovery of spiritual poems and their deep meaning in the Mouride tradition.',
                    'ar' => 'اكتشاف القصائد الروحية ومعناها العميق في التقليد المريدي'
                ],
                'youtube_video_id' => 'L_jWHffIx5E', // ID YouTube valide pour test
                'youtube_original_url' => 'https://www.youtube.com/watch?v=L_jWHffIx5E',
                'start_time' => 0,
                'end_time' => 90,
                'trailer_duration' => 90,
                'category' => 'khassaids',
                'featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'tags' => ['khassaids', 'poésie', 'spiritualité'],
                'slug' => 'khassaid-poesie-spirituelle-cheikh-ahmadou-bamba'
            ],
            [
                'title' => [
                    'fr' => 'Témoignages de Disciples : Vécu Spirituel',
                    'en' => 'Testimonies of Disciples: Spiritual Experience',
                    'ar' => 'شهادات المريدين: التجربة الروحية'
                ],
                'description' => [
                    'fr' => 'Récits authentiques de disciples sur leur parcours spirituel dans la voie mouride.',
                    'en' => 'Authentic accounts of disciples about their spiritual journey in the Mouride way.',
                    'ar' => 'حسابات أصلية للمريدين حول رحلتهم الروحية في الطريقة المريدية'
                ],
                'youtube_video_id' => 'kJQP7kiw5Fk', // ID YouTube valide pour test
                'youtube_original_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                'start_time' => 0,
                'end_time' => 120,
                'trailer_duration' => 120,
                'category' => 'temoignages',
                'featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'tags' => ['témoignages', 'disciples', 'spiritualité'],
                'slug' => 'temoignages-disciples-vecu-spirituel'
            ]
        ];

        foreach ($trailers as $trailerData) {
            VideoTrailer::create($trailerData);
        }
    }
}
