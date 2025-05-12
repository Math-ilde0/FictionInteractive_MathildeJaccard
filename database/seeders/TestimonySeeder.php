<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimony;

class TestimonySeeder extends Seeder
{
    public function run()
    {
        $testimonies = [
            [
                'title' => 'Ma première session à l’HEIG-VD',
                'content' => 'Je suis arrivé stressé, mais les cours et les collègues m’ont aidé à prendre mes marques. Le rythme est intense mais passionnant.',
            ],
            [
                'title' => 'Gérer les projets de groupe',
                'content' => 'Les projets de groupe m’ont appris la communication et la gestion du temps. C’est parfois compliqué, mais formateur.',
            ],
            [
                'title' => 'Quand le stress monte',
                'content' => 'Il y a des semaines où tout s’accumule : rendus, examens, fatigue. J’ai appris à prioriser et à demander de l’aide.',
            ],
            [
                'title' => 'Une charge mentale trop lourde',
                'content' => 'Pendant un moment, je n’arrivais plus à décrocher. J’ai parlé à un conseiller et ça m’a beaucoup aidé à relâcher la pression.',
            ],
            [
                'title' => 'Retrouver un équilibre',
                'content' => 'J’ai commencé à faire du sport entre les cours. Juste 30 minutes par jour, mais ça change tout.',
            ],
            [
                'title' => 'Les pauses sont essentielles',
                'content' => 'J’avais tendance à enchaîner sans m’arrêter. Depuis que je prends des vraies pauses, je suis plus productif et moins épuisé.',
            ],
            [
                'title' => 'Partager ses difficultés',
                'content' => 'Le jour où j’ai osé dire que j’en avais marre, mes collègues m’ont soutenu. C’est important de ne pas rester seul.',
            ],
            [
                'title' => 'L’importance de la planification',
                'content' => 'J’utilise désormais un agenda physique. Ça m’aide à mieux visualiser la semaine et réduire l’anxiété.',
            ],
            [
                'title' => 'Quand tout devient trop',
                'content' => 'Il y a eu un moment où j’ai envisagé d’arrêter. Heureusement, j’ai trouvé du soutien auprès de l’école et de mes amis.',
            ],
            [
                'title' => 'Trouver du sens dans les études',
                'content' => 'Même quand c’est dur, se rappeler pourquoi on est là et ce qu’on veut faire plus tard me motive à continuer.',
            ],
        ];

        foreach ($testimonies as $data) {
            Testimony::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => 1,
                'status' => 'published'
            ]);
            
        }
    }
}
