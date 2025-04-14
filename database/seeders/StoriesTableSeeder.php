<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\Choice;
use App\Models\Chapter;

class StoriesTableSeeder extends Seeder
{
    public function run()
    {
        // Créer l'histoire
        $story = Story::create([
            'title' => 'Évite le Burnout',
            'summary' => 'Une aventure interactive où tu vas devoir naviguer à travers une semaine intense et stressante. Tu as des deadlines à respecter, des cours à suivre, des relations à maintenir, et ton bien-être personnel à préserver. Chaque décision que tu prends aura un impact sur ton niveau de stress et de fatigue. Est-ce que tu vas succomber à l’épuisement ou trouver une manière de rester en équilibre ? Cette histoire est un parcours où chaque choix te rapproche ou t’éloigne d’un burn-out. Fais face à tes responsabilités et à tes émotions tout en essayant de rester productif et motivé. Parviendras-tu à garder ta santé mentale intacte tout en accomplissant tout ce que tu as à faire ?',
        ]);

        // Créer les chapitres associés à l'histoire
        // Crée les chapitres pour l'histoire 1
        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 1,
            'content' => 'Ce lundi matin, tu ouvres les yeux après une nuit de sommeil un peu trop courte. Ton réveil sonne bruyamment, te rappelant qu’une nouvelle semaine commence. Tu as trois deadlines à respecter pour cette semaine. Ton travail t’attend, mais tu te sens déjà épuisé·e par tout ce qui s’annonce. Le stress te serre la gorge, et tu n’as même pas encore mis un pied hors du lit. Que fais-tu ? Est-ce que tu vas te lever et commencer ta journée en tentant de tout gérer d’un coup, ou vas-tu choisir de rester au lit, espérant que la journée se passera mieux ? Le stress monte en toi à chaque seconde qui passe. Les deadlines sont là, inévitables, et tu sais que si tu n’agis pas, cela ne fera qu’empirer. Mais ton corps te crie de ralentir, de respirer un peu. Alors, qu’est-ce que tu choisis ? Rester sous la couette et repousser l’inévitable, ou bien sortir du lit et attaquer cette journée de front, peu importe combien tu te sens fatigué·e ?'
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 2,
            'content' => 'Tu vas au cours, mais tu t’endors en classe. Le professeur te donne un devoir à rendre dans deux jours, mais tu sais déjà que ce sera difficile. L’anxiété commence à monter en toi à mesure que tu réalises que la charge de travail devient écrasante. Ton esprit divague, et tu ne sais même plus à quel moment tu t’es perdu. Que faire ? Tu pourrais essayer de suivre le rythme et rester concentré·e, mais la fatigue te rattrape. Ou peut-être devrais-tu abandonner pour aujourd’hui et repartir chez toi pour reprendre des forces ? Chaque choix a ses conséquences, et tu te demandes si tu as fait le bon. Est-ce que tu vas encore avancer malgré tout ou choisir de t’arrêter et te donner un peu de répit ?'
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 3,
            'content' => 'Tu restes au lit et dors deux heures de plus. Le confort du matelas te garde dans un état de semi-sommeil. Ton esprit est apaisé pour un instant, mais la culpabilité s’installe lentement. Tu sais que tu devrais être en train de travailler, mais la fatigue te submerge. Pourtant, ce moment de pause te permet de respirer un peu. Tu as oublié à quel point il est important de prendre soin de soi avant de se lancer dans une période intense de travail. Après ces deux heures, tu te lèves, un peu plus reposé·e mais toujours sous pression. La question qui te brûle les lèvres : comment avancer maintenant que tu sais que la journée avance sans toi ?'
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 4,
            'content' => 'Après t’être réveillé·e, tu décides d’attaquer ta journée avec plus de calme. Tu organises un peu tes tâches, mais le stress commence à revenir. Tu te demandes si tu vas réussir à tout gérer. Les deadlines te pèsent, mais tu prends une profonde inspiration et te dis qu’il est encore possible d’y arriver. Chaque tâche est une montagne à gravir, mais tu sais qu’en y allant petit à petit, tu y arriveras. Mais au fond, tu te demandes si tu as les ressources pour tout accomplir sans craquer sous la pression. Est-ce que cette journée sera celle où tu réussis, ou celle où tu abandonnes ?'
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 5,
            'content' => 'Tu choisis de t’attaquer à un projet important, celui que tu avais laissé de côté pendant trop longtemps. La difficulté, c’est qu’il semble impossible à terminer en une journée. Mais tu te sens déterminé·e à avancer. Les heures passent et tu progresses petit à petit, mais la pression continue de s’intensifier. Le monde semble ralentir autour de toi, et tu te demandes si tu es sur la bonne voie. Le stress est encore là, mais tu es plus fort·e qu’hier. Chaque tâche accomplie te donne un peu plus d’espoir. Mais au fond de toi, une question persiste : est-ce que cela suffira à tout boucler avant la fin de la semaine ?'
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 6,
            'content' => 'Il est tard, et tu commences à te sentir épuisé·e. Mais tu as réussi à avancer. Les progrès sont là, et pourtant, le stress ne cesse d’augmenter. Tu n’arrives pas à te concentrer, ton esprit vagabonde. Il te faut une pause, mais la culpabilité t’en empêche. Chaque minute passée sans travailler te semble volée. Tu as l’impression d’être pris·e dans un cercle vicieux, où chaque effort semble être contrebalancé par la pression de plus en plus grande. Mais alors, peut-être que tu devrais prendre un moment pour respirer et reprendre ton énergie. Est-ce que c’est un signe de faiblesse ou un moyen de préserver ta santé mentale ?'
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 7,
            'content' => 'Tu décides de faire une pause. Après tout, tu es humain·e et tu as besoin de te ressourcer. Tu te lèves, tu prends un peu d’air, tu fais une activité relaxante pour te vider la tête. Une heure plus tard, tu te sens revigoré·e, prêt·e à repartir dans la bataille. Parfois, il faut savoir s’arrêter pour mieux repartir. Tu réalises que tu as fait une erreur en pensant que tu devais constamment être productif·ve. Ce moment de calme t’aide à réévaluer tes priorités. Peut-être qu’il est temps de réajuster tes objectifs, de lâcher prise sur certaines choses pour mieux avancer dans le long terme.'
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 8,
            'content' => 'La journée touche à sa fin, et tu as réussi à accomplir beaucoup de choses. Pourtant, tu te sens épuisé·e et tu as encore beaucoup de travail devant toi. Le stress est toujours là, mais tu es plus serein·e qu’avant. Tu as trouvé ton rythme, et c’est peut-être ça la clé. Tu sais que demain sera encore plus difficile, mais tu as l’impression que tu peux gérer, tant que tu restes organisé·e et calme. Le plus dur semble derrière toi, mais la route est encore longue. Cependant, tu te sens plus fort·e qu’avant. Ce qui semblait impossible devient maintenant faisable.'
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 9,
            'content' => 'Tu as maintenant pris conscience de l’importance de t’organiser et de prendre des pauses. Tout devient plus facile quand tu sais ce que tu dois faire. Le stress n’a pas disparu, mais il est plus gérable. Tu sais que tu peux compter sur ta détermination pour accomplir ce que tu as à faire. L’angoisse de ne pas finir à temps est toujours présente, mais tu l’acceptes. Tu n’as plus peur de l’échec, car tu sais que, même si ça prend plus de temps, tu vas réussir à boucler tout ça.'
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 10,
            'content' => 'Finalement, tu as terminé tout ce que tu avais à faire. La semaine la plus stressante de ton semestre est maintenant derrière toi. Tu te sens épuisé·e, mais aussi fier·e d’avoir traversé tout cela. Les deadlines ont été respectées, et tu n’as pas craqué sous la pression. Tu as appris à gérer ton stress et à avancer malgré les difficultés. Cette expérience t’a changé, et tu sais maintenant que tu es capable de gérer n’importe quelle situation, aussi stressante soit-elle. La leçon est apprise. Tu es prêt·e à faire face à de nouveaux défis.'
        ]);
        // Chapitre 1 - Choix disponibles
        Choice::create([
            'text' => 'Se lever et attaquer la journée.',
            'next_chapter_id' => 2, // Va au chapitre 2
            'chapter_id' => 1
        ]);

        Choice::create([
            'text' => 'Rester au lit et espérer que la journée passe.',
            'next_chapter_id' => 3, // Va au chapitre 3
            'chapter_id' => 1
        ]);

        // Chapitre 2 - Choix disponibles
        Choice::create([
            'text' => 'Essayer de rester concentré au cours malgré la fatigue.',
            'next_chapter_id' => 4, // Va au chapitre 4
            'chapter_id' => 2
        ]);

        Choice::create([
            'text' => 'Sortir discrètement de la classe pour prendre l’air.',
            'next_chapter_id' => 5, // Va au chapitre 5
            'chapter_id' => 2
        ]);

        // Chapitre 3 - Choix disponibles
        Choice::create([
            'text' => 'Essayer de te rattraper sur ton travail en attendant le réveil.',
            'next_chapter_id' => 6, // Va au chapitre 6
            'chapter_id' => 3
        ]);

        Choice::create([
            'text' => 'Accepter que la journée soit perdue et ne rien faire.',
            'next_chapter_id' => 7, // Va au chapitre 7
            'chapter_id' => 3
        ]);

        // Chapitre 4 - Choix disponibles
        Choice::create([
            'text' => 'Aller parler au professeur pour expliquer ta situation.',
            'next_chapter_id' => 8, // Va au chapitre 8
            'chapter_id' => 4
        ]);

        Choice::create([
            'text' => 'Continuer à travailler tout en ayant du mal à rester concentré.',
            'next_chapter_id' => 9, // Va au chapitre 9
            'chapter_id' => 4
        ]);

        // Chapitre 5 - Choix disponibles
        Choice::create([
            'text' => 'Essayer de trouver une solution pour équilibrer ton emploi du temps.',
            'next_chapter_id' => 10, // Va au chapitre 10
            'chapter_id' => 5
        ]);

        Choice::create([
            'text' => 'Te rendre à l’infirmerie et espérer récupérer.',
            'next_chapter_id' => null, // Fin de l’histoire
            'chapter_id' => 5
        ]);

        // Chapitre 6 - Choix disponibles
        Choice::create([
            'text' => 'Parler à un ami pour lui expliquer ta situation.',
            'next_chapter_id' => 8, // Va au chapitre 8
            'chapter_id' => 6
        ]);

        Choice::create([
            'text' => 'Prendre une longue pause pour te remettre d’aplomb.',
            'next_chapter_id' => 9, // Va au chapitre 9
            'chapter_id' => 6
        ]);

        // Chapitre 7 - Choix disponibles
        Choice::create([
            'text' => 'Passer du temps à méditer et organiser tes tâches.',
            'next_chapter_id' => 10, // Va au chapitre 10
            'chapter_id' => 7
        ]);

        Choice::create([
            'text' => 'Continuer à procrastiner et espérer que tout s’arrange.',
            'next_chapter_id' => null, // Fin de l’histoire
            'chapter_id' => 7
        ]);

        // Chapitre 8 - Choix disponibles
        Choice::create([
            'text' => 'Prendre un jour de repos et retourner à l’école le lendemain.',
            'next_chapter_id' => null, // Fin de l’histoire
            'chapter_id' => 8
        ]);

        Choice::create([
            'text' => 'Demander une extension pour la remise de ton travail.',
            'next_chapter_id' => 10, // Va au chapitre 10
            'chapter_id' => 8
        ]);

        // Chapitre 9 - Choix disponibles
        Choice::create([
            'text' => 'Prendre un jour pour te reposer et recommencer plus tard.',
            'next_chapter_id' => null, // Fin de l’histoire
            'chapter_id' => 9
        ]);

        Choice::create([
            'text' => 'Demander à un collègue de t’aider pour finir ton travail.',
            'next_chapter_id' => 10, // Va au chapitre 10
            'chapter_id' => 9
        ]);

        // Chapitre 10 - Choix disponibles
        Choice::create([
            'text' => 'Organiser un plan de travail plus structuré pour les semaines à venir.',
            'next_chapter_id' => null, // Fin de l’histoire
            'chapter_id' => 10
        ]);

        Choice::create([
            'text' => 'Réfléchir à ton avenir et à tes priorités dans la vie.',
            'next_chapter_id' => null, // Fin de l’histoire
            'chapter_id' => 10
        ]);
    }
}