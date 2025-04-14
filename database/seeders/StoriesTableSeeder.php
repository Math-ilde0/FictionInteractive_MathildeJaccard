<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\Choice;
use App\Models\Chapter;
use Illuminate\Support\Facades\Schema;

class StoriesTableSeeder extends Seeder
{
    public function run()
    {
        // Avant d'ajouter de nouvelles données, vidons les tables existantes
        Schema::disableForeignKeyConstraints();
        Choice::truncate();
        Chapter::truncate();
        Story::truncate();
        Schema::enableForeignKeyConstraints();

        // Créer l'histoire
       $story = Story::create([
    'title' => 'Évite le Burnout',
    'summary' => 'Une aventure interactive où tu vas devoir naviguer à travers une semaine intense et stressante. Tu as des deadlines à respecter, des cours à suivre, des relations à maintenir, et ton bien-être personnel à préserver. Chaque décision que tu prends aura un impact sur ton niveau de stress et de fatigue. Est-ce que tu vas succomber à l\'épuisement ou trouver une manière de rester en équilibre ? Cette histoire est un parcours où chaque choix te rapproche ou t\'éloigne d\'un burn-out. Fais face à tes responsabilités et à tes émotions tout en essayant de rester productif et motivé. Parviendras-tu à garder ta santé mentale intacte tout en accomplissant tout ce que tu as à faire ?',
    'error' => 'Si tu rencontres une erreur, n\'hésite pas à nous contacter pour nous en faire part.',
    ]);

        // Créer les chapitres associés à l'histoire
        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 1,
            'content' => 'Ce lundi matin, ton réveil sonne comme un hurlement dans tes oreilles. L\'écran de ton téléphone clignote 6:30, beaucoup trop tôt. Ton cerveau embrumé te rappelle immédiatement la liste des tâches qui t\'attendent: trois deadlines cette semaine, un projet de groupe, et ce devoir que tu as reporté depuis deux semaines. Ton cœur s\'emballe déjà, et tu n\'as même pas encore posé un pied par terre. Le plafond te fixe, impassible, alors que ton anxiété monte comme une marée. Le poids de tes responsabilités semble clouer ton corps au matelas. La couette, elle, t\'invite à rester au chaud, à ignorer le monde extérieur. Juste cinq minutes de plus... Mais au fond, tu sais que chaque minute de procrastination ajoutera à ton stress plus tard.',
            'stress_level' => 5,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 2,
            'content' => 'L\'amphithéâtre ressemble à une caverne sombre où les mots du professeur rebondissent comme des échos lointains. Tes paupières sont des poids de plomb. Le PowerPoint devant toi devient flou. Tu sens ta tête dodeliner, puis sursautes quand ton menton touche ta poitrine. "Et n\'oubliez pas," la voix du professeur te ramène brièvement à la réalité, "le devoir pour mercredi." Un nouveau devoir? Ton estomac se noue. L\'angoisse fait battre ton cœur plus vite. Autour de toi, tes camarades prennent des notes avec application. Tu essaies de te concentrer, mais ton cerveau ressemble à un radio mal réglée, captant des fragments d\'informations entre deux parasites de fatigue. La température de la salle semble grimper, et l\'air devient étouffant.',
            'stress_level' => 7,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 3,
            'content' => 'Le monde extérieur continue sa course folle pendant que tu reposes dans ce cocon de draps chauds. Le soleil grimpe lentement, projetant des rayons dorés qui dansent sur le mur. Tu t\'enfonces dans ce délicieux état entre rêve et éveil, où les problèmes semblent lointains, séparés de toi par un voile brumeux. Mais comme un invité indésirable, la culpabilité s\'installe à côté de toi. Chaque tic-tac de l\'horloge murale te rappelle que le temps file, indifférent à ton besoin de repos. Tes deadlines ne t\'attendront pas. Tu fermes les yeux plus fort, essayant d\'ignorer cette voix accusatrice, mais elle persiste, comme un moustique bourdonnant près de ton oreille. Deux heures plus tard, quand tu émerges enfin, la chambre baigne dans une lumière différente. Le monde a continué sans toi.',
            'stress_level' => 4,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 4,
            'content' => 'Le soleil de l\'après-midi inonde ton bureau improvisé au coin du salon. Une tasse de thé fumant à portée de main, tu commences par dresser une liste. Les tâches, une fois écrites noir sur blanc, semblent moins intimidantes. Tu coches les petites victoires: répondre aux emails, organiser tes notes. Chaque tâche terminée est comme une pierre retirée du sac à dos invisible que tu portes. L\'horloge tourne, mais tu avances. Le stress rode encore, faisant des allers-retours dans ton esprit comme un loup en cage. Il te rappelle constamment le temps qui passe, les attentes, la possibilité d\'échec. Mais tu respires profondément, ramenant ton attention au document devant toi. Une page après l\'autre, tu construis ton château de cartes, espérant qu\'une bourrasque d\'imprévu ne viendra pas tout faire s\'écrouler.',
            'stress_level' => 4,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 5,
            'content' => 'Le projet te fixe depuis ton écran comme un gouffre sans fond. Ce devoir négligé, laissé à mûrir dans un coin de ton disque dur, te nargue maintenant avec son échéance imminente. Les heures passent comme des minutes alors que tu plonges dans le travail. Ton téléphone vibre - messages, notifications sociales - mais ils appartiennent à un autre monde. Le tien s\'est rétréci à la taille de ton écran. Dehors, le ciel change de couleur, passant du bleu au orange, puis au bleu profond. Tu ne remarques pas. Ton poignet commence à protester contre ce marathon de frappe. Des picotements dans tes doigts, une tension dans ton cou. Ton corps te parle, mais tu l\'ignores. "Juste un peu plus," te promets-tu, encore et encore, repoussant les limites de ta concentration comme un élastique qu\'on étire trop loin.',
            'stress_level' => 6,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 6,
            'content' => 'La nuit est tombée et ton bureau n\'est plus éclairé que par la lumière bleuâtre de ton écran. Tes yeux brûlent, tes épaules sont nouées comme des cordes de marin. Les mots commencent à danser devant toi, se mélangeant dans une soupe de lettres sans sens. Ton cerveau, autrefois vif et précis, ressemble maintenant à un moteur qui tousse et crache, fonctionnant sur ses dernières réserves. Tu as fait des progrès, certes. Des pages de contenu, des problèmes résolus, des concepts développés. Mais chaque avancée semble révéler trois nouvelles tâches à accomplir. L\'épuisement et l\'angoisse se disputent la première place dans ton corps. "Continue," dit une voix dans ta tête. "Arrête," supplie une autre. Le conflit intérieur fait rage, aussi bruyant que le silence qui t\'entoure.',
            'stress_level' => 8,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 7,
            'content' => 'L\'air frais du parc est comme une gorgée d\'eau fraîche pour ton esprit assoiffé. Les feuilles bruissent doucement au-dessus de toi, créant une symphonie naturelle qui apaise tes pensées agitées. Tu as laissé ton téléphone en mode avion, créant une bulle temporelle où les emails et les rappels n\'existent pas. Pendant une heure, tu n\'es plus un étudiant submergé, mais simplement un humain qui respire. Tu observes un écureuil zigzaguer entre les arbres, totalement absorbé par l\'instant présent, sans se soucier du passé ou du futur. Une leçon silencieuse de sa part. Quand tu reprends le chemin de chez toi, quelque chose a changé. Pas tes obligations - elles t\'attendent, immuables. C\'est ton regard qui s\'est transformé. Comme si tu avais ajusté la mise au point d\'un appareil photo, voyant enfin clairement ce qui était flou.',
            'stress_level' => 3,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 8,
            'content' => 'Le bureau de ton professeur est encombré de livres et de papiers, des strates de connaissances accumulées comme des couches géologiques. Il t\'écoute attentivement, sans jugement dans son regard. "Je comprends," dit-il quand tu finis d\'expliquer ta situation. Ces deux mots simples agissent comme un baume sur ton anxiété. "Voici ce que je propose..." Il esquisse un plan, un chemin à travers ce qui semblait être une forêt impénétrable. Tu prends des notes frénétiquement, chaque point comme une bouée de sauvetage. En sortant de son bureau, le couloir semble plus lumineux qu\'avant. Le poids sur tes épaules n\'a pas disparu, mais il s\'est allégé, devenu gérable. Tu te diriges vers la bibliothèque avec un objectif clair, comme un navigateur qui a enfin trouvé son étoile polaire après une nuit de brouillard.',
            'stress_level' => 5,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 9,
            'content' => 'Le soleil se lève sur un nouveau jour, et avec lui, une nouvelle façon d\'aborder ton travail. Tu as divisé la montagne en collines, segmenté le marathon en sprints gérables. Sur ton mur, un tableau visuel affiche tes priorités - non plus comme une liste accusatrice, mais comme une carte routière. Les tâches urgentes sont en rouge, les importantes en orange, les secondaires en vert. Chaque post-it déplacé dans la colonne "terminé" est une petite victoire célébrée. Tu as installé une application qui te rappelle de faire des pauses, de boire de l\'eau, de t\'étirer. Ton corps et ton esprit ne sont plus des adversaires dans cette bataille, mais des alliés qui travaillent en harmonie. L\'anxiété n\'a pas disparu - elle rode toujours, comme une ombre à la périphérie de ta vision - mais elle n\'est plus aux commandes.',
            'stress_level' => 4,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 10,
            'content' => 'Le vendredi arrive comme la ligne d\'arrivée d\'une course d\'endurance. Tes muscles mentaux sont endoloris, mais tu ressens cette fatigue particulière qui vient de l\'accomplissement, pas de l\'épuisement vide. Tu regardes ton bureau, autrefois champ de bataille, maintenant terrain conquis. Les deadlines ont été respectées, les travaux rendus, les emails traités. Tu as navigué à travers cette semaine tempétueuse sans chavirer. En réfléchissant, tu réalises que ce n\'est pas tant la quantité de travail qui a changé, mais ta façon de l\'aborder. Tu as appris à reconnaître les signes avant-coureurs du burnout, à respecter tes limites sans te juger. Cette leçon, plus que n\'importe quel cours théorique, restera avec toi. En fermant ton ordinateur, tu ressens quelque chose qui ressemble à de la fierté. Pas seulement pour ce que tu as accompli, mais pour qui tu es devenu à travers ces épreuves.',
            'stress_level' => 2,
        ]);

        // Nouveaux chapitres

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 11,
            'content' => 'Le lundi suivant arrive avec son lot de nouveaux défis. Tu te retrouves face à un projet de groupe inattendu, annoncé à la dernière minute par un professeur qui semble ignorer que vous avez d\'autres cours. Autour de toi, tes camarades échangent des regards paniqués. Mais toi, étrangement, tu restes calme. Tu observes cette tempête émotionnelle collective comme un météorologue observe un orage - avec curiosité plutôt qu\'avec peur. "On pourrait se retrouver à la bibliothèque ce soir pour commencer," proposes-tu au groupe. Tes mots surprennent même tes propres oreilles. D\'où vient cette assurance? Cette capacité à transformer l\'obstacle en opportunité? Un sourire se dessine sur ton visage alors que tu réalises: la semaine dernière t\'a transformé. Les épreuves traversées ont forgé en toi quelque chose de nouveau, comme une épée trempée dans le feu qui en ressort plus forte.',
            'stress_level' => 3,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 12,
            'content' => 'La réunion de groupe s\'éternise, les voix se chevauchent comme des vagues désordonnées. Chacun défend son idée, personne n\'écoute vraiment. L\'horloge murale semble narguer ton emploi du temps soigneusement planifié. Une heure perdue, puis deux. La frustration monte en toi comme une marée, menaçant d\'engloutir ta patience fraîchement acquise. Tu sens le stress ancien qui frappe à la porte de ton esprit, demandant à être réadmis. Tes mains tremblent légèrement sous la table, tes tempes palpitent au rythme d\'un métronome affolé. Autour de toi, les discussions stériles continuent. Un choix s\'impose: reprendre le contrôle de la situation ou laisser l\'anxiété reprendre les commandes. Dans cette salle surchauffée où l\'air devient rare, tu te retrouves à un carrefour familier. La voie que tu choisiras maintenant pourrait définir non seulement l\'issue de ce projet, mais aussi ton rapport au stress pour les semaines à venir.',
            'stress_level' => 6,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 13,
            'content' => 'Tu te lèves calmement, attirant l\'attention du groupe. "J\'ai une proposition," dis-tu d\'une voix posée qui contraste avec le chaos précédent. Tu exposes un plan structuré, divisant le projet en sections distinctes, assignant des tâches selon les forces de chacun. Tes mots créent une architecture dans l\'air, un échafaudage sur lequel vos idées dispersées peuvent enfin s\'accrocher. Le groupe se tait, surpris par cette clarté soudaine. Un à un, ils acquiescent, soulagés que quelqu\'un prenne l\'initiative. En sortant de la réunion, tu reçois des remerciements sincères. "Comment fais-tu pour rester si calme?" te demande une camarade. Tu réfléchis un instant. La vérité est que tu n\'es pas calme à l\'intérieur - le stress est toujours là, comme une rivière sous la glace. Mais tu as appris à naviguer avec lui plutôt que contre lui. "C\'est une pratique quotidienne," réponds-tu simplement. Sur le chemin du retour, le ciel s\'assombrit, promettant de la pluie. Pourtant, tu te sens étrangement ensoleillé.',
            'stress_level' => 4,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 14,
            'content' => 'La nuit est profonde quand tu termines finalement ta partie du projet. Ton appartement est silencieux, hormis le ronronnement distant du réfrigérateur et le clic régulier de ton clavier. Tu t\'étires, sentant chaque vertèbre protester contre les heures passées dans la même position. À côté de ton ordinateur, une tasse de thé refroidi témoigne du temps écoulé. Tu devrais être épuisé, mais curieusement, une énergie tranquille t\'habite. C\'est différent de l\'adrénaline frénétique des nuits blanches d\'autrefois. Cette énergie est plus profonde, plus stable - comme une braise plutôt qu\'une flamme. Tu te lèves et t\'approches de la fenêtre. La ville dort sous un voile de lumières artificielles, chaque fenêtre illuminée raconte une histoire différente. Combien de personnes, comme toi, sont en train de lutter avec leurs propres défis? Cette pensée, loin de t\'isoler, te connecte à un réseau invisible d\'humanité partagée. Tu n\'es pas seul dans cette bataille. Pour la première fois depuis longtemps, le futur avec ses incertitudes ne t\'effraie plus. Il t\'intrigue.',
            'stress_level' => 3,
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'chapter_number' => 15,
            'content' => 'Le semestre touche à sa fin, marqué par une succession de projets rendus, d\'examens passés, de défis relevés. Tu te tiens sur le campus, observant les étudiants qui se pressent autour de toi, chacun absorbé dans son propre monde. Le vent fait danser les feuilles d\'automne à tes pieds, créant des motifs éphémères avant de les disperser à nouveau. Un cycle naturel de création et de dissolution qui te rappelle étrangement ton propre parcours ces dernières semaines. Tu as connu le chaos et l\'ordre, l\'anxiété et la sérénité, la défaite et la victoire. Tu portes maintenant ces expériences comme un cartographe porte la connaissance des terres explorées. Le burnout n\'est plus un monstre mythique, mais un territoire que tu as appris à reconnaître et à éviter. Désormais, tu sais que prendre soin de ton bien-être n\'est pas un luxe, mais une nécessité aussi fondamentale que respirer. En marchant vers ta prochaine destination, tu emportes avec toi cette sagesse durement acquise. Le chemin devant toi ne sera pas moins exigeant, mais tu le parcourras différemment - avec conscience, compassion et cette résilience tranquille qui vient de s\'être confronté à ses limites, et d\'avoir appris à les respecter.',
            'stress_level' => 2,
        ]);

        // Chapitre 1 - Choix disponibles
        Choice::create([
            'text' => 'Se lever et attaquer la journée avec détermination.',
            'next_chapter_id' => 2, // Va au chapitre 2
            'chapter_id' => 1
        ]);

        Choice::create([
            'text' => 'Rester au lit pour récupérer des forces.',
            'next_chapter_id' => 3, // Va au chapitre 3
            'chapter_id' => 1
        ]);

        // Chapitre 2 - Choix disponibles
        Choice::create([
            'text' => 'Lutter contre la fatigue et rester en cours coûte que coûte.',
            'next_chapter_id' => 4, // Va au chapitre 4
            'chapter_id' => 2
        ]);

        Choice::create([
            'text' => 'Sortir discrètement pour prendre l\'air et éclaircir tes idées.',
            'next_chapter_id' => 5, // Va au chapitre 5
            'chapter_id' => 2
        ]);

        // Chapitre 3 - Choix disponibles
        Choice::create([
            'text' => 'Profiter de ce moment de calme pour planifier stratégiquement ta journée.',
            'next_chapter_id' => 6, // Va au chapitre 6
            'chapter_id' => 3
        ]);

        Choice::create([
            'text' => 'Accepter que cette journée sera différente et pratiquer l\'auto-compassion.',
            'next_chapter_id' => 7, // Va au chapitre 7
            'chapter_id' => 3
        ]);

        // Chapitre 4 - Choix disponibles
        Choice::create([
            'text' => 'Consulter ton professeur pour trouver une solution adaptée à ta situation.',
            'next_chapter_id' => 8, // Va au chapitre 8
            'chapter_id' => 4
        ]);

        Choice::create([
            'text' => 'Persévérer seul et développer ta propre méthode d\'organisation.',
            'next_chapter_id' => 9, // Va au chapitre 9
            'chapter_id' => 4
        ]);

        // Chapitre 5 - Choix disponibles
        Choice::create([
            'text' => 'Repenser ton approche du travail et créer un système d\'équilibre.',
            'next_chapter_id' => 10, // Va au chapitre 10
            'chapter_id' => 5
        ]);

        Choice::create([
            'text' => 'Reconnaître tes limites et chercher du soutien externe.',
            'next_chapter_id' => 11, // Va au chapitre 11 (nouveau)
            'chapter_id' => 5
        ]);

        // Chapitre 6 - Choix disponibles
        Choice::create([
            'text' => 'Partager ton fardeau avec un ami de confiance.',
            'next_chapter_id' => 8, // Va au chapitre 8
            'chapter_id' => 6
        ]);

        Choice::create([
            'text' => 'Prendre une pause consciente pour recharger ton énergie mentale.',
            'next_chapter_id' => 9, // Va au chapitre 9
            'chapter_id' => 6
        ]);

        // Chapitre 7 - Choix disponibles
        Choice::create([
            'text' => 'Transformer ce moment de repos en opportunité de réflexion profonde.',
            'next_chapter_id' => 12, // Va au chapitre 12 (nouveau)
            'chapter_id' => 7
        ]);

        Choice::create([
            'text' => 'Continuer à t\'accorder du temps sans culpabilité.',
            'next_chapter_id' => 13, // Va au chapitre 13 (nouveau)
            'chapter_id' => 7
        ]);

        // Chapitre 8 - Choix disponibles
        Choice::create([
            'text' => 'Intégrer les conseils reçus et prendre un jour pour restructurer ton approche.',
            'next_chapter_id' => 14, // Va au chapitre 14 (nouveau)
            'chapter_id' => 8
        ]);

        Choice::create([
            'text' => 'Négocier des délais supplémentaires pour préserver ta santé mentale.',
            'next_chapter_id' => 10, // Va au chapitre 10
            'chapter_id' => 8
        ]);

        // Chapitre 9 - Choix disponibles
        Choice::create([
            'text' => 'Cultiver cette nouvelle conscience et l\'appliquer à tous les aspects de ta vie.',
            'next_chapter_id' => 15, // Va au chapitre 15 (nouveau)
            'chapter_id' => 9
        ]);

        Choice::create([
            'text' => 'Rassembler une équipe de soutien pour les défis à venir.',
            'next_chapter_id' => 10, // Va au chapitre 10
            'chapter_id' => 9
        ]);

        // Chapitre 10 - Choix disponibles
        Choice::create([
            'text' => 'Formaliser tes apprentissages dans un journal de réflexion personnel.',
            'next_chapter_id' => 15, // Va au chapitre 15 (nouveau)
            'chapter_id' => 10
        ]);

        Choice::create([
            'text' => 'Célébrer tes victoires et planifier ton prochain défi avec confiance.',
            'next_chapter_id' => null, // Fin de l'histoire
            'chapter_id' => 10
        ]);

        // Chapitre 11 - Choix disponibles (nouveau)
        Choice::create([
            'text' => 'Utiliser cette expérience pour développer tes compétences de leadership.',
            'next_chapter_id' => 13, // Va au chapitre 13
            'chapter_id' => 11
        ]);

        Choice::create([
            'text' => 'Explorer des méthodes alternatives de gestion du stress.',
            'next_chapter_id' => 12, // Va au chapitre 12
            'chapter_id' => 11
        ]);

        // Chapitre 12 - Choix disponibles (nouveau)
        Choice::create([
            'text' => 'Prendre en main la situation difficile avec une approche structurée.',
            'next_chapter_id' => 14, // Va au chapitre 14
            'chapter_id' => 12
        ]);

        Choice::create([
            'text' => 'Rechercher un équilibre en déléguant certaines responsabilités.',
            'next_chapter_id' => 15, // Va au chapitre 15
            'chapter_id' => 12
        ]);

        // Chapitre 13 - Choix disponibles (nouveau)
        Choice::create([
            'text' => 'Approfondir ta pratique de pleine conscience au quotidien.',
            'next_chapter_id' => 15, // Va au chapitre 15
            'chapter_id' => 13
        ]);

        Choice::create([
            'text' => 'Partager tes découvertes avec d\'autres personnes stressées.',
            'next_chapter_id' => 14, // Va au chapitre 14
            'chapter_id' => 13
        ]);

        // Chapitre 14 - Choix disponibles (nouveau)
        Choice::create([
            'text' => 'Intégrer définitivement ces pratiques dans ta routine quotidienne.',
            'next_chapter_id' => 15, // Va au chapitre 15
            'chapter_id' => 14
        ]);

        Choice::create([
            'text' => 'Chercher à approfondir ta compréhension des mécanismes du stress.',
            'next_chapter_id' => null, // Fin de l'histoire
            'chapter_id' => 14
        ]);

        // Chapitre 15 - Choix disponibles (nouveau)
        Choice::create([
            'text' => 'Embrasser cette nouvelle version de toi-même avec confiance.',
            'next_chapter_id' => null, // Fin de l'histoire
            'chapter_id' => 15
        ]);

        Choice::create([
            'text' => 'Utiliser ton expérience pour aider les autres à éviter le burnout.',
            'next_chapter_id' => null, // Fin de l'histoire
            'chapter_id' => 15
        ]);
    }
}