<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Biographie;

class TestBiographySeeder extends Seeder
{
    public function run(): void
    {
        $biographies = [
            [
                'title' => [
                    'fr' => 'Cheikh Ahmadou Bamba Mbacké',
                    'en' => 'Sheikh Ahmadou Bamba Mbacké',
                    'ar' => 'الشيخ أحمدو بامبا مباكي'
                ],
                'author_name' => [
                    'fr' => 'Fondateur du Mouridisme',
                    'en' => 'Founder of Mouridism',
                    'ar' => 'مؤسس الطريقة المريدية'
                ],
                'description' => [
                    'fr' => '<p><strong>Cheikh Ahmadou Bamba Mbacké</strong> (1853-1927) est le fondateur de la confrérie soufie mouride au Sénégal.</p><p>Né à <em>Mbacké-Baol</em>, il était un érudit religieux, poète et mystique qui a révolutionné l\'enseignement islamique au Sénégal.</p><h2>Ses contributions majeures :</h2><ul><li>Fondation de la ville sainte de Touba</li><li>Développement d\'une pédagogie islamique innovante</li><li>Promotion du travail comme forme d\'adoration</li><li>Résistance pacifique contre le colonialisme français</li></ul><blockquote>« Le travail fait partie de la religion »</blockquote><p>Son héritage spirituel continue d\'influencer des millions de disciples à travers le monde.</p>',
                    'en' => '<p><strong>Sheikh Ahmadou Bamba Mbacké</strong> (1853-1927) was the founder of the Mouride Sufi brotherhood in Senegal.</p><p>Born in <em>Mbacké-Baol</em>, he was a religious scholar, poet and mystic who revolutionized Islamic teaching in Senegal.</p><h2>His major contributions:</h2><ul><li>Foundation of the holy city of Touba</li><li>Development of innovative Islamic pedagogy</li><li>Promotion of work as a form of worship</li><li>Peaceful resistance against French colonialism</li></ul><blockquote>"Work is part of religion"</blockquote><p>His spiritual legacy continues to influence millions of disciples worldwide.</p>'
                ],
                'type' => 'biographie',
                'category' => 'cheikh_ahmadou_bamba',
                'langue' => 'Français',
                'date_publication' => '1927-01-01',
                'is_published' => true,
                'featured' => true,
                'disponible_en_ligne' => true
            ],
            [
                'title' => [
                    'fr' => 'Serigne Fallou Mbacké',
                    'en' => 'Serigne Fallou Mbacké',
                    'ar' => 'سرين فالو مباكي'
                ],
                'author_name' => [
                    'fr' => 'Premier Khalife Général des Mourides',
                    'en' => 'First General Caliph of the Mourides'
                ],
                'description' => [
                    'fr' => '<p><strong>Serigne Fallou Mbacké</strong> (1888-1968) fut le premier Khalife Général des Mourides après son père Cheikh Ahmadou Bamba.</p><p>Il a consolidé l\'organisation de la confrérie et développé les infrastructures de Touba.</p><h3>Réalisations principales :</h3><ul><li>Construction de la Grande Mosquée de Touba</li><li>Organisation administrative de la confrérie</li><li>Développement économique de Touba</li></ul>',
                    'en' => '<p><strong>Serigne Fallou Mbacké</strong> (1888-1968) was the first General Caliph of the Mourides after his father Sheikh Ahmadou Bamba.</p><p>He consolidated the organization of the brotherhood and developed Touba\'s infrastructure.</p><h3>Main achievements:</h3><ul><li>Construction of the Great Mosque of Touba</li><li>Administrative organization of the brotherhood</li><li>Economic development of Touba</li></ul>'
                ],
                'type' => 'biographie',
                'category' => 'khalifes',
                'langue' => 'Français',
                'date_publication' => '1968-01-01',
                'is_published' => true,
                'featured' => true,
                'disponible_en_ligne' => true
            ],
            [
                'title' => [
                    'fr' => 'Serigne Mouhamadou Moustapha Mbacké',
                    'en' => 'Serigne Mouhamadou Moustapha Mbacké'
                ],
                'author_name' => [
                    'fr' => 'Fils de Cheikh Ahmadou Bamba',
                    'en' => 'Son of Sheikh Ahmadou Bamba'
                ],
                'description' => [
                    'fr' => '<p><strong>Serigne Mouhamadou Moustapha Mbacké</strong> était l\'un des fils les plus érudits de Cheikh Ahmadou Bamba.</p><p>Spécialiste de la jurisprudence islamique et des sciences religieuses, il a contribué à la formation de nombreux disciples.</p><h3>Domaines d\'expertise :</h3><ul><li>Fiqh (jurisprudence islamique)</li><li>Tafsir (exégèse coranique)</li><li>Tasawwuf (soufisme)</li></ul>',
                    'en' => '<p><strong>Serigne Mouhamadou Moustapha Mbacké</strong> was one of the most learned sons of Sheikh Ahmadou Bamba.</p><p>A specialist in Islamic jurisprudence and religious sciences, he contributed to the training of many disciples.</p><h3>Areas of expertise:</h3><ul><li>Fiqh (Islamic jurisprudence)</li><li>Tafsir (Quranic exegesis)</li><li>Tasawwuf (Sufism)</li></ul>'
                ],
                'type' => 'biographie',
                'category' => 'fils',
                'langue' => 'Français',
                'date_publication' => '1945-01-01',
                'is_published' => true,
                'featured' => false,
                'disponible_en_ligne' => true
            ]
        ];

        foreach ($biographies as $biographyData) {
            Biographie::create($biographyData);
            $this->command->info('Biographie créée : ' . $biographyData['title']['fr']);
        }
    }
}
