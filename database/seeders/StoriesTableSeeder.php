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
        Schema::disableForeignKeyConstraints();
        Choice::truncate();
        Chapter::truncate();
        Story::truncate();
        Schema::enableForeignKeyConstraints();

        $stories = [
            [
                'title' => 'Évite le Burnout',
                'summary' => 'Une aventure interactive où chaque décision affecte ta charge mentale : plus ce chiffre est élevé, plus tu te rapproches de l\'épuisement mental. Parviendras-tu à maintenir l\'équilibre ou finiras-tu en burnout ?',
                'chapters' => [
                    [
                        'chapter_number' => 1,
                        'content' => 'Ce lundi matin, ton réveil hurle à 6h30 comme une alarme de fin du monde. Tu ouvres difficilement les yeux. Ta chambre est encore baignée dans l\'obscurité, mais ton cerveau s\'active déjà, bombardé par la liste interminable des tâches à accomplir. Trois deadlines dans la semaine, une réunion de projet que tu redoutes, des mails qui s\'empilent comme des menaces silencieuses. Ton cœur s\'accélère, ton estomac se noue, et tu n\'as même pas encore posé un pied au sol. Tu restes allongé quelques secondes, paralysé par l\'avalanche de responsabilités. Le plafond devient ton miroir, froid et impassible, pendant que tes pensées tournent en boucle. Tu pourrais te lever maintenant et affronter la journée, ou bien t\'enfouir un peu plus profondément sous la couette et faire semblant que le monde extérieur n\'existe pas. Les deux options t\'épuisent. Ton téléphone clignote avec une nouvelle notification. Rien d\'urgent, mais suffisant pour ajouter une couche de pression. Tu inspires profondément, essayant de rassembler assez d\'énergie pour bouger. Une voix dans ta tête murmure : "Tu ne tiendras pas la semaine comme ça." Une autre réplique : "Juste une chose à la fois."',
                        'stress_level' => 0,
                        'stress_impact' => 1,
                        'is_recovery_point' => false,
                        'stress_advice' => 'Commencer en étant lucide sur ta charge peut t\'aider à mieux la gérer.',
                        'choices' => [
                            [
                                'text' => 'Te lever, sauter le petit-déj et foncer directement dans ta boîte mail.',
                                'next_chapter_number' => 2
                            ],
                            [
                                'text' => 'Prendre 15 minutes pour un vrai petit-déj et respirer.',
                                'next_chapter_number' => 3
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 2,
                        'content' => 'Tu arrives en cours avec quelques minutes de retard. L\'amphithéâtre est déjà plongé dans un silence pesant, uniquement troublé par la voix monocorde du professeur. Tu t\'installes en essayant de ne pas faire de bruit, ton sac glisse de ton épaule et frappe légèrement la chaise. Quelques têtes se tournent vers toi. Gêné, tu ouvres ton ordinateur. Le PowerPoint projeté est dense. Trop dense. Tes yeux tentent de suivre les lignes, mais tes paupières sont lourdes, comme lestées de plomb. Ton cerveau est encore en mode brouillard. Tu n\'as même pas pris de petit déjeuner. Les mots du prof deviennent un fond sonore indistinct, comme une radio mal captée. "Et n\'oubliez pas le devoir pour mercredi", lâche-t-il soudain. Tu sursautes. Quel devoir ? Tu regardes autour de toi, cherchant un regard rassurant. Mais tout le monde semble savoir de quoi il parle. Tu te sens isolé, déconnecté. Tu te forces à taper quelques notes, mais rien ne fait sens. Ta tête dodeline, ton cou se crispe. Tu sens que tu atteins déjà ta limite alors que la journée vient à peine de commencer. L\'air est lourd, oppressant. Et cette petite voix revient : "Tu n\'y arriveras pas."',
                        'stress_level' => 3,
                        'stress_impact' => 2,
                        'is_recovery_point' => false,
                        'stress_advice' => 'Dire "oui" tout le temps, c\'est dire "non" à toi-même.',
                        'choices' => [
                            [
                                'text' => 'Boire un café et continuer à encaisser sans broncher.',
                                'next_chapter_number' => 4
                            ],
                            [
                                'text' => 'Faire une pause, marcher 10 minutes dehors.',
                                'next_chapter_number' => 3
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 3,
                        'content' => 'Tu as pris le temps de respirer et de te recentrer. Le simple fait de t\'accorder cette pause te fait déjà sentir plus léger. L\'air frais emplit tes poumons, et tu te rappelles l\'importance de ces petits moments pour toi-même. En marchant, tu commences à organiser tes pensées. Ce n\'est pas la fin du monde si tu ne réponds pas à tous ces messages dans l\'heure qui suit. La journée s\'annonce chargée, mais en la découpant en petites étapes gérables, elle devient moins intimidante. Tu te répètes : "Une chose à la fois". En rentrant, tu te sens déjà plus lucide, plus présent. Les défis sont toujours là, mais ton regard sur eux a changé. Peut-être que la clé n\'est pas de courir plus vite, mais de mieux choisir son chemin.',
                        'stress_level' => 0,
                        'stress_impact' => -1, // Impact négatif = réduction du stress
                        'is_recovery_point' => true,
                        'stress_advice' => 'S\'organiser réduit la charge mentale invisible.',
                        'choices' => [
                            [
                                'text' => 'Prendre une grande respiration, puis planifier ta journée dans un agenda.',
                                'next_chapter_number' => 5
                            ],
                            [
                                'text' => 'Ouvrir TikTok "juste 5 minutes" (spoiler: ce sera 45).',
                                'next_chapter_number' => 6
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 4,
                        'content' => 'L\'après-midi avance, et tu t\'es finalement installé dans un coin du salon avec ton ordinateur. Une tasse de thé refroidit doucement à côté de toi. Tu ouvres ton agenda numérique : c\'est une jungle. Des alertes rouges clignotent comme des signaux de détresse. Tu inspires profondément, et pour une fois, tu ne paniques pas. Tu ouvres une feuille blanche et commences à écrire. Liste de tâches, par ordre d\'urgence. Cocher une ligne, puis une autre. Une satisfaction minuscule, mais réelle. Mais le calme ne dure jamais longtemps. Une pensée parasite surgit : "Tu aurais dû faire ça hier", puis une autre : "Tu vas finir en retard, comme d\'habitude". Le stress rode, silencieux, prêt à bondir au moindre faux pas. Tu sens une tension dans ta nuque. Tu te forces à rester concentré. Ce n\'est pas le moment de flancher. Tu veux prouver que tu peux t\'en sortir seul. Mais au fond de toi, une voix douce te dit que tu n\'es pas obligé de porter tout ça sans aide. Tu l\'entends, mais tu ne l\'écoutes pas encore.',
                        'stress_level' => 6,
                        'stress_impact' => 3,
                        'is_recovery_point' => false,
                        'stress_advice' => 'Ton corps n\'est pas un robot.',
                        'choices' => [
                            [
                                'text' => 'Prendre un cachet et continuer sans pause.',
                                'next_chapter_number' => 99
                            ],
                            [
                                'text' => 'Couper la caméra et te lever pour t\'étirer 5 min.',
                                'next_chapter_number' => 5
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 5,
                        'content' => 'Tu es devant ton écran depuis des heures. Le devoir te fixe comme un mur infranchissable. Tu t\'es juré de le faire ce matin, puis à midi, puis après le café. Et te voilà, la nuit tombée, à peine commencé. Tu tapes, tu supprimes, tu recommences. Ton esprit est embrumé, mais tu continues. Tu ne veux pas abandonner. Autour de toi, le monde s\'éteint peu à peu. Les fenêtres des voisins s\'obscurcissent. Ton téléphone vibre, mais tu l\'ignores. Tu n\'as pas le temps de répondre. Même respirer devient une corvée. Ton corps te supplie de t\'arrêter : picotements dans les doigts, tension dans le cou, vertiges légers. Tu bois une gorgée d\'eau tiède et reprends. Chaque phrase écrite est une victoire, chaque paragraphe un combat. Tu refuses de lâcher prise. "Encore un peu", te répètes-tu. Mais l\'élasticité mentale que tu tires depuis des jours est sur le point de rompre. Et tu le sais. Pourtant, tu continues.',
                        'stress_level' => 2,
                        'stress_impact' => 1,
                        'is_recovery_point' => false,
                        'stress_advice' => 'Prendre du recul est un signe de maturité mentale.',
                        'choices' => [
                            [
                                'text' => 'Continuer tranquillement avec des pauses régulières.',
                                'next_chapter_number' => 15
                            ],
                            [
                                'text' => 'Accepter encore une mission urgente envoyée par ton boss.',
                                'next_chapter_number' => 6
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 6,
                        'content' => 'Il est tard. Très tard. L\'éclat bleu de ton écran est la seule lumière dans la pièce. Tu fixes ton document, les lignes s\'entrelacent comme des serpents sans queue ni tête. Tu n\'as plus la force de comprendre ce que tu écris. Tes yeux piquent, tes tempes battent, et tes épaules semblent prêtes à se désintégrer. Tu n\'as pas mangé. Tu n\'as pas bougé. Tu te rends compte que tu n\'as pas dit un mot depuis des heures. Tu es seul, dans une bulle de performance où chaque minute est un compte à rebours vers un épuisement que tu refuses d\'admettre. Tu es dépassé, mais tu continues. Comme si arrêter maintenant signifiait échouer. Tu te parles à toi-même, en silence : "Encore un effort", "Juste une dernière page". Mais cette page se multiplie. La tâche n\'en finit plus. Tu regardes l\'heure. 3h12. Et tu es toujours là. Tu sais que tu frôles tes limites, mais tu ne veux pas l\'accepter. Alors tu restes assis. Encore un peu.',
                        'stress_level' => 5,
                        'stress_impact' => 3,
                        'is_recovery_point' => false,
                        'stress_advice' => 'Multitâche permanent = mental brisé.',
                        'choices' => [
                            [
                                'text' => 'Continuer jusqu\'à 2h du matin, café à la main.',
                                'next_chapter_number' => 99
                            ],
                            [
                                'text' => 'Fermer tout, mettre un minuteur, et te concentrer sur une seule tâche.',
                                'next_chapter_number' => 5
                            ]
                        ]
                    ],
                    
                    
                    [
                        'chapter_number' => 7,
                        'content' => 'Tu t\'es isolé dans la salle d\'étude, mais rien ne rentre. Tu relis la même phrase cinq fois sans comprendre. Autour de toi, les autres tapent, lisent, avancent. Toi, tu te bats juste pour rester éveillé. Tu as une boule au ventre, mais tu ignores ton corps. Tu serres les dents. Tu refuses de lâcher. Tu refuses d\'échouer. La pression monte. Tu te dis que tu ne peux pas prendre de pause. Pas maintenant. Pourtant, ta vision se brouille, ton cœur s\'emballe. Mais tu restes là, à te convaincre que "ça passera".',
                        'stress_level' => 4,
                        'stress_impact' => 2,
                        'is_recovery_point' => false,
                        'stress_advice' => 'L\'obstination n\'est pas du courage quand elle devient une déconnexion de soi.',
                        'choices' => [
                            [
                                'text' => 'Boire un énergisant et t\'accrocher, coûte que coûte.',
                                'next_chapter_number' => 99
                            ],
                            [
                                'text' => 'Sortir t\'aérer quelques minutes et respirer en pleine conscience.',
                                'next_chapter_number' => 8
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 8,
                        'content' => 'Le silence de la bibliothèque est apaisant. Tu te poses. Tu ouvres ton carnet. Plutôt que de foncer tête baissée, tu planifies. Tu écris. Tu classes. Tu redonnes une forme au chaos. Tes mains tremblent encore, mais ton esprit s\'éclaircit. Tu passes enfin du mode "survie" au mode "réflexion". Tu ajustes tes objectifs, réalistes cette fois. Un petit pas. Puis un autre. Tu retrouves le goût d\'avancer sans te détruire.',
                        'stress_level' => 3,
                        'stress_impact' => -2, // Impact négatif = réduction du stress
                        'is_recovery_point' => true,
                        'stress_advice' => 'Faire une pause stratégique, ce n\'est pas perdre du temps. C\'est en gagner.',
                        'choices' => [
                            [
                                'text' => 'Continuer à planifier et structurer ta semaine sereinement.',
                                'next_chapter_number' => 9
                            ],
                            [
                                'text' => 'Relancer tous les projets en parallèle dès ce soir.',
                                'next_chapter_number' => 99
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 9,
                        'content' => 'Tu t\'installes dans un café. Un chocolat chaud, des écouteurs, une playlist focus. C\'est étrange comme un cadre différent peut changer l\'état d\'esprit. Tu ne penses pas à "finir", tu penses à "faire un pas". Le document s\'ouvre, et tu avances. Tu n\'as pas tout géré, mais tu as repris la barre. C\'est plus qu\'une victoire : c\'est un revirement.',
                        'stress_level' => 2,
                        'stress_impact' => -1, // Impact négatif = réduction du stress
                        'is_recovery_point' => true,
                        'stress_advice' => 'Changer de contexte peut suffire à désamorcer une spirale.',
                        'choices' => [
                            [
                                'text' => 'Terminer une tâche importante avant la fin de la journée.',
                                'next_chapter_number' => 10
                            ],
                            [
                                'text' => 'Répondre à tous les mails, lancer deux projets et finir le PowerPoint ce soir.',
                                'next_chapter_number' => 99
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 10,
                        'content' => 'Tu fermes ton ordi. Tu te sens vidé, mais lucide. Tu ne t\'es pas dispersé. Tu n\'as pas tout fait, mais tu n\'as pas tout sacrifié. Tu prends une grande inspiration. La semaine est loin d\'être terminée, mais tu sens que tu peux y arriver. Tu regardes ton agenda, et pour la première fois, tu souris. Pas parce qu\'il est vide, mais parce qu\'il est possible.',
                        'stress_level' => 3,
                        'stress_impact' => -2, // Impact négatif = réduction du stress
                        'is_recovery_point' => true,
                        'stress_advice' => 'Le vrai succès, c\'est de garder ton mental intact jusqu\'au bout.',
                        'choices' => [
                            [
                                'text' => 'Aller courir ou cuisiner quelque chose de bon pour toi.',
                                'next_chapter_number' => 11
                            ],
                            [
                                'text' => 'Te lancer dans la relecture de tous tes projets avant minuit.',
                                'next_chapter_number' => 99
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 11,
                        'content' => 'Tu reçois un message. "Réu à 18h, projet à revoir." Tu fronces les sourcils. Tu pensais souffler ce soir. Tu hésites. Puis tu ouvres ton ordi. Encore. Tu relis les commentaires, tu prends des notes. Ton esprit te dit stop, ton corps aussi, mais tu continues. Un collègue envoie un vocal, 2 minutes de reproches déguisés. Tu ricanes nerveusement. Tu as envie de hurler, mais tu tapes une réponse polie. Tu sacrifies encore ton temps perso, encore ton énergie. Et tu te demandes... si tu vas t\'en sortir.',
                        'stress_level' => 4,
                        'stress_impact' => 2,
                        'is_recovery_point' => false,
                        'stress_advice' => 'Ton temps n\'est pas une ressource infinie.',
                        'choices' => [
                            [
                                'text' => 'Tout accepter et refaire le travail sans broncher.',
                                'next_chapter_number' => 99
                            ],
                            [
                                'text' => 'Proposer un délai et prendre une vraie pause ce soir.',
                                'next_chapter_number' => 12
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 12,
                        'content' => 'Tu t\'es imposé un stop. C\'est rare. Tu t\'allonges, casque sur les oreilles, playlist douce. Tu repenses à la semaine. Les moments où tu as tenu bon. Les moments où tu as craqué. Tu te rends compte que tout s\'enchaîne trop vite. Tu n\'as jamais le temps de respirer entre deux feux. Et ce soir, pour la première fois depuis longtemps, tu respires. Vraiment. Le silence te fait peur au début. Puis il t\'apaise.',
                        'stress_level' => 2,
                        'stress_impact' => -3, // Impact négatif = réduction du stress
                        'is_recovery_point' => true,
                        'stress_advice' => 'Laisser passer l\'orage intérieur, c\'est mieux que le fuir.',
                        'choices' => [
                            [
                                'text' => 'Programmer une pause régulière chaque jour.',
                                'next_chapter_number' => 13
                            ],
                            [
                                'text' => 'Compresser toute la to-do list demain pour "rattraper le retard".',
                                'next_chapter_number' => 99
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 13,
                        'content' => 'Tu as tenu parole. Pause à midi. Pause à 18h. Et tu as bossé entre deux sans te cramer. Incroyable. Tu réalises que ce que tu redoutais le plus — ralentir — est en fait ce qui t\'a permis d\'avancer. Tu croises quelqu\'un dans le couloir. "Tu sembles plus serein.e", dit-il. Tu souris. Tu n\'es pas guéri.e, mais tu es en chemin.',
                        'stress_level' => 2,
                        'stress_impact' => -2, // Impact négatif = réduction du stress
                        'is_recovery_point' => true,
                        'stress_advice' => 'Être bien ne veut pas dire être parfait. Juste présent.',
                        'choices' => [
                            [
                                'text' => 'Continuer sur ce rythme équilibré, même si c\'est lent.',
                                'next_chapter_number' => 14
                            ],
                            [
                                'text' => 'Relancer tous les projets pour "profiter de l\'élan".',
                                'next_chapter_number' => 99
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 14,
                        'content' => 'Tu as enfin compris que la productivité ne vaut rien sans ta santé mentale. Tu fermes les yeux. Pas pour dormir. Pour écouter ton corps. Tu sens la tension descendre de tes épaules. Tu n\'as rien accompli d\'extraordinaire aujourd\'hui. Et pourtant, tu te sens mieux que depuis longtemps. Tu n\'as pas brillé. Tu as juste tenu debout. Et c\'est déjà énorme.',
                        'stress_level' => 1,
                        'stress_impact' => -2, // Impact négatif = réduction du stress
                        'is_recovery_point' => true,
                        'stress_advice' => 'La paix intérieure est une performance en soi.',
                        'choices' => [
                            [
                                'text' => 'Écrire un message de gratitude à toi-même ou à un proche.',
                                'next_chapter_number' => 15
                            ],
                            [
                                'text' => 'Reprendre le dossier en retard juste "pour finir propre".',
                                'next_chapter_number' => 99
                            ]
                        ]
                    ],
                    
                    
                    
                    [
                        'chapter_number' => 15,
                        'content' => 'Tu arrives à la fin de la semaine, fatigué·e, mais encore debout. Tu as appris à écouter tes limites.',
                        'stress_level' => 2,
                        'stress_impact' => -1, // Impact négatif = réduction du stress
                        'is_recovery_point' => true,
                        'stress_advice' => 'Garder un équilibre, c\'est une victoire quotidienne.',
                        'choices' => [
                            [
                                'text' => 'Fêter ça avec une vraie pause sans écran.',
                                'next_chapter_number' => null
                            ],
                            [
                                'text' => 'Te jeter dans un nouveau projet sans réfléchir.',
                                'next_chapter_number' => 99
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 99,
                        'content' => 'Tu as atteint le niveau critique de charge mentale. Ton corps et ton esprit te lâchent. C\'est le burn-out. Tu ne peux plus avancer.',
                        'stress_level' => 10,
                        'stress_impact' => 0,
                        'is_recovery_point' => false,
                        'stress_advice' => 'Quand le corps dit stop, il faut écouter. Il n\'est jamais trop tard pour demander de l\'aide.',
                        'choices' => [
                            [
                                'text' => 'Tu t\'effondres.',
                                'next_chapter_number' => null
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($stories as $storyData) {
            $story = Story::create([
                'title' => $storyData['title'],
                'summary' => $storyData['summary']
            ]);

            $chapterModels = [];
            foreach ($storyData['chapters'] as $chapterData) {
                $chapter = Chapter::create([
                    'story_id' => $story->id,
                    'chapter_number' => $chapterData['chapter_number'],
                    'content' => $chapterData['content'],
                    'stress_level' => $chapterData['stress_level'],
                    'stress_impact' => $chapterData['stress_impact'],
                    'is_recovery_point' => $chapterData['is_recovery_point'],
                    'stress_advice' => $chapterData['stress_advice']
                ]);
                $chapterModels[$chapterData['chapter_number']] = $chapter;
            }

            foreach ($storyData['chapters'] as $chapterData) {
                $chapter = $chapterModels[$chapterData['chapter_number']];
                foreach ($chapterData['choices'] as $choiceData) {
                    $nextChapterId = isset($choiceData['next_chapter_number']) && isset($chapterModels[$choiceData['next_chapter_number']])
                        ? $chapterModels[$choiceData['next_chapter_number']]->id
                        : null;

                    Choice::create([
                        'chapter_id' => $chapter->id,
                        'text' => $choiceData['text'],
                        'next_chapter_id' => $nextChapterId
                    ]);
                }
            }
        }
    }
}