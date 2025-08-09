<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FilsCheikh;

class FilsCheikhSeeder extends Seeder
{
    public function run(): void
    {
        $filsCheikh = [
            [
                'name' => [
                    'fr' => 'Serigne Moustapha Mbacké',
                    'en' => 'Serigne Moustapha Mbacké',
                    'ar' => 'الشيخ مصطفى مباكي'
                ],
                'description' => [
                    'fr' => '2ème Khalife général des Mourides, grand érudit et poète.',
                    'en' => '2nd Khalif General of the Mourides, great scholar and poet.',
                    'ar' => 'الخليفة العام الثاني للمريدين، عالم وشاعر كبير'
                ],
                'biography' => [
                    'fr' => '<p>Serigne Moustapha Mbacké (1888-1945) fut le deuxième Khalife général de la confrérie mouride. Fils aîné de Cheikh Ahmadou Bamba, il a dirigé la communauté de 1927 à 1945. Grand érudit en sciences islamiques et poète de talent, il a composé de nombreux ouvrages et poèmes qui enrichissent le patrimoine spirituel mouride.</p>',
                    'en' => '<p>Serigne Moustapha Mbacké (1888-1945) was the second Khalif General of the Mouride brotherhood. Eldest son of Cheikh Ahmadou Bamba, he led the community from 1927 to 1945. A great scholar in Islamic sciences and talented poet, he composed numerous works and poems that enrich the Mouride spiritual heritage.</p>',
                    'ar' => '<p>الشيخ مصطفى مباكي (1888-1945) كان الخليفة العام الثاني للطريقة المريدية. ابن الشيخ أحمدو بامبا الأكبر، قاد الجماعة من 1927 إلى 1945. عالم كبير في العلوم الإسلامية وشاعر موهوب، ألف أعمالاً وقصائد عديدة تثري التراث الروحي المريدي.</p>'
                ],
                'slug' => 'serigne-moustapha-mbacke',
                'is_khalif' => true,
                'order_of_succession' => 2,
                'birth_date' => '1888-01-01',
                'death_date' => '1945-07-19',
                'is_published' => true,
            ],
            [
                'name' => [
                    'fr' => 'Serigne Mamadou Moustapha Mbacké',
                    'en' => 'Serigne Mamadou Moustapha Mbacké',
                    'ar' => 'الشيخ محمدو مصطفى مباكي'
                ],
                'description' => [
                    'fr' => '3ème Khalife général des Mourides, bâtisseur et modernisateur.',
                    'en' => '3rd Khalif General of the Mourides, builder and modernizer.',
                    'ar' => 'الخليفة العام الثالث للمريدين، باني ومجدد'
                ],
                'biography' => [
                    'fr' => '<p>Serigne Mamadou Moustapha Mbacké (1888-1967) fut le troisième Khalife général de la confrérie mouride. Fils de Cheikh Ahmadou Bamba, il a dirigé la communauté de 1945 à 1967. Il s\'est distingué par ses efforts de modernisation et de développement de Touba, transformant la ville sainte en un centre urbain moderne tout en préservant son caractère spirituel.</p>',
                    'en' => '<p>Serigne Mamadou Moustapha Mbacké (1888-1967) was the third Khalif General of the Mouride brotherhood. Son of Cheikh Ahmadou Bamba, he led the community from 1945 to 1967. He distinguished himself through his modernization efforts and development of Touba, transforming the holy city into a modern urban center while preserving its spiritual character.</p>',
                    'ar' => '<p>الشيخ محمدو مصطفى مباكي (1888-1967) كان الخليفة العام الثالث للطريقة المريدية. ابن الشيخ أحمدو بامبا، قاد الجماعة من 1945 إلى 1967. تميز بجهوده في التحديث وتطوير طوبى، محولاً المدينة المقدسة إلى مركز حضري حديث مع الحفاظ على طابعها الروحي.</p>'
                ],
                'slug' => 'serigne-mamadou-moustapha-mbacke',
                'is_khalif' => true,
                'order_of_succession' => 3,
                'birth_date' => '1888-01-01',
                'death_date' => '1967-12-23',
                'is_published' => true,
            ],
            [
                'name' => [
                    'fr' => 'Serigne Abdoul Ahad Mbacké',
                    'en' => 'Serigne Abdoul Ahad Mbacké',
                    'ar' => 'الشيخ عبد الأحد مباكي'
                ],
                'description' => [
                    'fr' => '4ème Khalife général des Mourides, promoteur de l\'agriculture.',
                    'en' => '4th Khalif General of the Mourides, promoter of agriculture.',
                    'ar' => 'الخليفة العام الرابع للمريدين، محرض الزراعة'
                ],
                'biography' => [
                    'fr' => '<p>Serigne Abdoul Ahad Mbacké (1914-1989) fut le quatrième Khalife général de la confrérie mouride. Fils de Cheikh Ahmadou Bamba, il a dirigé la communauté de 1968 à 1989. Passionné d\'agriculture, il a encouragé le développement de cette activité chez les mourides, fidèle aux enseignements de son père sur l\'importance du travail.</p>',
                    'en' => '<p>Serigne Abdoul Ahad Mbacké (1914-1989) was the fourth Khalif General of the Mouride brotherhood. Son of Cheikh Ahmadou Bamba, he led the community from 1968 to 1989. Passionate about agriculture, he encouraged the development of this activity among the Mourides, faithful to his father\'s teachings on the importance of work.</p>',
                    'ar' => '<p>الشيخ عبد الأحد مباكي (1914-1989) كان الخليفة العام الرابع للطريقة المريدية. ابن الشيخ أحمدو بامبا، قاد الجماعة من 1968 إلى 1989. كان شغوفاً بالزراعة، شجع تطوير هذا النشاط بين المريدين، مخلصاً لتعاليم والده حول أهمية العمل.</p>'
                ],
                'slug' => 'serigne-abdoul-ahad-mbacke',
                'is_khalif' => true,
                'order_of_succession' => 4,
                'birth_date' => '1914-01-01',
                'death_date' => '1989-06-23',
                'is_published' => true,
            ],
            [
                'name' => [
                    'fr' => 'Serigne Saliou Mbacké',
                    'en' => 'Serigne Saliou Mbacké',
                    'ar' => 'الشيخ صالح مباكي'
                ],
                'description' => [
                    'fr' => '5ème Khalife général des Mourides, homme de paix et de réconciliation.',
                    'en' => '5th Khalif General of the Mourides, man of peace and reconciliation.',
                    'ar' => 'الخليفة العام الخامس للمريدين، رجل السلام والمصالحة'
                ],
                'biography' => [
                    'fr' => '<p>Serigne Saliou Mbacké (1915-2007) fut le cinquième Khalife général de la confrérie mouride. Fils de Cheikh Ahmadou Bamba, il a dirigé la communauté de 1990 à 2007. Homme de paix et de réconciliation, il s\'est illustré par sa sagesse et son rôle de médiateur dans de nombreux conflits.</p>',
                    'en' => '<p>Serigne Saliou Mbacké (1915-2007) was the fifth Khalif General of the Mouride brotherhood. Son of Cheikh Ahmadou Bamba, he led the community from 1990 to 2007. A man of peace and reconciliation, he distinguished himself through his wisdom and his role as mediator in numerous conflicts.</p>',
                    'ar' => '<p>الشيخ صالح مباكي (1915-2007) كان الخليفة العام الخامس للطريقة المريدية. ابن الشيخ أحمدو بامبا، قاد الجماعة من 1990 إلى 2007. رجل سلام ومصالحة، تميز بحكمته ودوره كوسيط في صراعات عديدة.</p>'
                ],
                'slug' => 'serigne-saliou-mbacke',
                'is_khalif' => true,
                'order_of_succession' => 5,
                'birth_date' => '1915-01-01',
                'death_date' => '2007-12-28',
                'is_published' => true,
            ],
            [
                'name' => [
                    'fr' => 'Serigne Abdoul Aziz Sy Al Amine',
                    'en' => 'Serigne Abdoul Aziz Sy Al Amine',
                    'ar' => 'الشيخ عبد العزيز سي الأمين'
                ],
                'description' => [
                    'fr' => 'Grand érudit et théologien, fils spirituel de Cheikh Ahmadou Bamba.',
                    'en' => 'Great scholar and theologian, spiritual son of Cheikh Ahmadou Bamba.',
                    'ar' => 'عالم وفقيه كبير، ابن روحي للشيخ أحمدو بامبا'
                ],
                'biography' => [
                    'fr' => '<p>Serigne Abdoul Aziz Sy Al Amine était un grand érudit et théologien sénégalais, reconnu comme l\'un des fils spirituels de Cheikh Ahmadou Bamba. Spécialiste en sciences islamiques, il a contribué à la diffusion des enseignements mourides à travers ses écrits et son enseignement.</p>',
                    'en' => '<p>Serigne Abdoul Aziz Sy Al Amine was a great Senegalese scholar and theologian, recognized as one of the spiritual sons of Cheikh Ahmadou Bamba. A specialist in Islamic sciences, he contributed to the dissemination of Mouride teachings through his writings and teaching.</p>',
                    'ar' => '<p>الشيخ عبد العزيز سي الأمين كان عالماً وفقيهاً سنغالياً كبيراً، معترفاً به كأحد الأبناء الروحيين للشيخ أحمدو بامبا. متخصص في العلوم الإسلامية، ساهم في نشر التعاليم المريدية من خلال كتاباته وتعليمه.</p>'
                ],
                'slug' => 'serigne-abdoul-aziz-sy-al-amine',
                'is_khalif' => false,
                'birth_date' => '1904-01-01',
                'death_date' => '1997-01-01',
                'is_published' => true,
            ],
            [
                'name' => [
                    'fr' => 'Serigne Modou Kara Mbacké',
                    'en' => 'Serigne Modou Kara Mbacké',
                    'ar' => 'الشيخ مودو كارا مباكي'
                ],
                'description' => [
                    'fr' => 'Guide spirituel contemporain, petit-fils de Cheikh Ahmadou Bamba.',
                    'en' => 'Contemporary spiritual guide, grandson of Cheikh Ahmadou Bamba.',
                    'ar' => 'مرشد روحي معاصر، حفيد الشيخ أحمدو بامبا'
                ],
                'biography' => [
                    'fr' => '<p>Serigne Modou Kara Mbacké est un guide spirituel mouride contemporain, petit-fils de Cheikh Ahmadou Bamba. Né en 1945, il est reconnu pour ses enseignements spirituels et son engagement dans les questions sociales et politiques du Sénégal.</p>',
                    'en' => '<p>Serigne Modou Kara Mbacké is a contemporary Mouride spiritual guide, grandson of Cheikh Ahmadou Bamba. Born in 1945, he is recognized for his spiritual teachings and his involvement in the social and political issues of Senegal.</p>',
                    'ar' => '<p>الشيخ مودو كارا مباكي مرشد روحي مريدي معاصر، حفيد الشيخ أحمدو بامبا. وُلد عام 1945، معروف بتعاليمه الروحية ومشاركته في القضايا الاجتماعية والسياسية في السنغال.</p>'
                ],
                'slug' => 'serigne-modou-kara-mbacke',
                'is_khalif' => false,
                'birth_date' => '1945-01-01',
                'is_published' => true,
            ]
        ];

        foreach ($filsCheikh as $fils) {
            FilsCheikh::create($fils);
        }
    }
}
