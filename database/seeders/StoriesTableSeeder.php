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
        // Disable foreign key constraints
        Schema::disableForeignKeyConstraints();
        Choice::truncate();
        Chapter::truncate();
        Story::truncate();
        Schema::enableForeignKeyConstraints();

        // Define stories with their details
        $stories = [
            [
                'title' => 'Évite le Burnout',
                'summary' => 'Une aventure interactive où tu vas devoir naviguer à travers une semaine intense et stressante. Tu as des deadlines à respecter, des cours à suivre, des relations à maintenir, et ton bien-être personnel à préserver. Chaque décision que tu prends aura un impact sur ton niveau de stress et de fatigue. Est-ce que tu vas succomber à l\'épuisement ou trouver une manière de rester en équilibre ? Cette histoire est un parcours où chaque choix te rapproche ou t\'éloigne d\'un burn-out. Fais face à tes responsabilités et à tes émotions tout en essayant de rester productif et motivé. Parviendras-tu à garder ta santé mentale intacte tout en accomplissant tout ce que tu as à faire ?',
                'chapters' => [
                    [
                        'chapter_number' => 1,
                        'content' => 'Ce lundi matin, ton réveil sonne comme un hurlement dans tes oreilles. L\'écran de ton téléphone clignote 6:30, beaucoup trop tôt. Ton cerveau embrumé te rappelle immédiatement la liste des tâches qui t\'attendent: trois deadlines cette semaine, un projet de groupe, et ce devoir que tu as reporté depuis deux semaines. Ton cœur s\'emballe déjà, et tu n\'as même pas encore posé un pied par terre. Le plafond te fixe, impassible, alors que ton anxiété monte comme une marée. Le poids de tes responsabilités semble clouer ton corps au matelas. La couette, elle, t\'invite à rester au chaud, à ignorer le monde extérieur. Juste cinq minutes de plus... Mais au fond, tu sais que chaque minute de procrastination ajoutera à ton stress plus tard.',
                        'stress_level' => 3,
                        'stress_impact' => 2,
                        'stress_advice' => 'La première étape est de reconnaître ton état et d\'agir avec compassion.',
                        'choices' => [
                            [
                                'text' => 'Se lever et attaquer la journée avec détermination.',
                                'stress_impact' => 1,
                                'stress_advice' => 'Commencer est souvent la partie la plus difficile. Sois gentil avec toi-même.',
                                'next_chapter_number' => 2
                            ],
                            [
                                'text' => 'Rester au lit pour récupérer des forces.',
                                'stress_impact' => 3,
                                'stress_advice' => 'La procrastination peut augmenter l\'anxiété à long terme.',
                                'next_chapter_number' => 3
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 2,
                        'content' => 'L\'amphithéâtre ressemble à une caverne sombre où les mots du professeur rebondissent comme des échos lointains. Tes paupières sont des poids de plomb. Le PowerPoint devant toi devient flou. Tu sens ta tête dodeliner, puis sursautes quand ton menton touche ta poitrine. "Et n\'oubliez pas," la voix du professeur te ramène brièvement à la réalité, "le devoir pour mercredi." Un nouveau devoir? Ton estomac se noue. L\'angoisse fait battre ton cœur plus vite. Autour de toi, tes camarades prennent des notes avec application. Tu essaies de te concentrer, mais ton cerveau ressemble à un radio mal réglée, captant des fragments d\'informations entre deux parasites de fatigue. La température de la salle semble grimper, et l\'air devient étouffant.',
                        'stress_level' => 2,
                        'stress_impact' => 2,
                        'stress_advice' => 'Écoute les signaux de fatigue de ton corps. Le repos est aussi important que le travail.',
                        'choices' => [
                            [
                                'text' => 'Lutter contre la fatigue et rester en cours coûte que coûte.',
                                'stress_impact' => 3,
                                'stress_advice' => 'Forcer la concentration peut être contre-productif et épuisant.',
                                'next_chapter_number' => 4
                            ],
                            [
                                'text' => 'Sortir discrètement pour prendre l\'air et éclaircir tes idées.',
                                'stress_impact' => 1,
                                'stress_advice' => 'Faire une pause peut aider à se reconnecter et à retrouver sa concentration.',
                                'next_chapter_number' => 5
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 3,
                        'content' => 'Le monde extérieur continue sa course folle pendant que tu reposes dans ce cocon de draps chauds. Le soleil grimpe lentement, projetant des rayons dorés qui dansent sur le mur. Tu t\'enfonces dans ce délicieux état entre rêve et éveil, où les problèmes semblent lointains, séparés de toi par un voile brumeux. Mais comme un invité indésirable, la culpabilité s\'installe à côté de toi. Chaque tic-tac de l\'horloge murale te rappelle que le temps file, indifférent à ton besoin de repos. Tes deadlines ne t\'attendront pas. Tu fermes les yeux plus fort, essayant d\'ignorer cette voix accusatrice, mais elle persiste, comme un moustique bourdonnant près de ton oreille. Deux heures plus tard, quand tu émerges enfin, la chambre baigne dans une lumière différente. Le monde a continué sans toi.',
                        'stress_level' => 1,
                        'stress_impact' => 3,
                        'stress_advice' => 'La culpabilité ne fait qu\'ajouter du stress. Accepte que le repos soit nécessaire.',
                        'choices' => [
                            [
                                'text' => 'Profiter de ce moment de calme pour planifier stratégiquement ta journée.',
                                'stress_impact' => 1,
                                'stress_advice' => 'La planification peut réduire l\'anxiété et donner un sentiment de contrôle.',
                                'next_chapter_number' => 6
                            ],
                            [
                                'text' => 'Accepter que cette journée sera différente et pratiquer l\'auto-compassion.',
                                'stress_impact' => 2,
                                'stress_advice' => 'L\'auto-compassion est un outil puissant contre le stress.',
                                'next_chapter_number' => 7
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 4,
                        'content' => 'Le soleil de l\'après-midi inonde ton bureau improvisé au coin du salon. Une tasse de thé fumant à portée de main, tu commences par dresser une liste. Les tâches, une fois écrites noir sur blanc, semblent moins intimidantes. Tu coches les petites victoires: répondre aux emails, organiser tes notes. Chaque tâche terminée est comme une pierre retirée du sac à dos invisible que tu portes. L\'horloge tourne, mais tu avances. Le stress rode encore, faisant des allers-retours dans ton esprit comme un loup en cage. Il te rappelle constamment le temps qui passe, les attentes, la possibilité d\'échec. Mais tu respires profondément, ramenant ton attention au document devant toi. Une page après l\'autre, tu construis ton château de cartes, espérant qu\'une bourrasque d\'imprévu ne viendra pas tout faire s\'écrouler.',
                        'stress_level' => 2,
                        'stress_impact' => 2,
                        'stress_advice' => 'Célèbre tes petites victoires. Chaque étape compte.',
                        'choices' => [
                            [
                                'text' => 'Consulter ton professeur pour trouver une solution adaptée à ta situation.',
                                'stress_impact' => 1,
                                'stress_advice' => 'Demander de l\'aide est un signe de force, pas de faiblesse.',
                                'next_chapter_number' => 8
                            ],
                            [
                                'text' => 'Persévérer seul et développer ta propre méthode d\'organisation.',
                                'stress_impact' => 3,
                                'stress_advice' => 'L\'isolement peut augmenter le stress et réduire l\'efficacité.',
                                'next_chapter_number' => 9
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 5,
                        'content' => 'Le projet te fixe depuis ton écran comme un gouffre sans fond. Ce devoir négligé, laissé à mûrir dans un coin de ton disque dur, te nargue maintenant avec son échéance imminente. Les heures passent comme des minutes alors que tu plonges dans le travail. Ton téléphone vibre - messages, notifications sociales - mais ils appartiennent à un autre monde. Le tien s\'est rétréci à la taille de ton écran. Dehors, le ciel change de couleur, passant du bleu au orange, puis au bleu profond. Tu ne remarques pas. Ton poignet commence à protester contre ce marathon de frappe. Des picotements dans tes doigts, une tension dans ton cou. Ton corps te parle, mais tu l\'ignores. "Juste un peu plus," te promets-tu, encore et encore, repoussant les limites de ta concentration comme un élastique qu\'on étire trop loin.',
                        'stress_level' => 1,
                        'stress_impact' => 3,
                        'stress_advice' => 'Écoute les signaux de ton corps. La santé physique et mentale est prioritaire.',
                        'choices' => [
                            [
                                'text' => 'Repenser ton approche du travail et créer un système d\'équilibre.',
                                'stress_impact' => 1,
                                'stress_advice' => 'Un système d\'organisation peut réduire significativement le stress.',
                                'next_chapter_number' => 10
                            ],
                            [
                                'text' => 'Reconnaître tes limites et chercher du soutien externe.',
                                'stress_impact' => 2,
                                'stress_advice' => 'Demander de l\'aide n\'est pas un échec, c\'est une stratégie intelligente.',
                                'next_chapter_number' => 11
                            ]
                        ]
                            ],
                            [
                                'chapter_number' => 6,
                                'content' => 'La nuit est tombée et ton bureau n\'est plus éclairé que par la lumière bleuâtre de ton écran. Tes yeux brûlent, tes épaules sont nouées comme des cordes de marin. Les mots commencent à danser devant toi, se mélangeant dans une soupe de lettres sans sens. Ton cerveau, autrefois vif et précis, ressemble maintenant à un moteur qui tousse et crache, fonctionnant sur ses dernières réserves. Tu as fait des progrès, certes. Des pages de contenu, des problèmes résolus, des concepts développés. Mais chaque avancée semble révéler trois nouvelles tâches à accomplir. L\'épuisement et l\'angoisse se disputent la première place dans ton corps. "Continue," dit une voix dans ta tête. "Arrête," supplie une autre. Le conflit intérieur fait rage, aussi bruyant que le silence qui t\'entoure.',
                                'stress_level' => 1,
                                'stress_impact' => 3,
                                'stress_advice' => 'Reconnaître ses limites est crucial. Le repos est aussi important que le travail.',
                                'choices' => [
                                    [
                                        'text' => 'Partager ton fardeau avec un ami de confiance.',
                                        'stress_impact' => 1,
                                        'stress_advice' => 'Le soutien social peut réduire significativement le stress.',
                                        'next_chapter_number' => 8
                                    ],
                                    [
                                        'text' => 'Prendre une pause consciente pour recharger ton énergie mentale.',
                                        'stress_impact' => 2,
                                        'stress_advice' => 'Les pauses stratégiques peuvent améliorer la productivité et réduire l\'épuisement.',
                                        'next_chapter_number' => 9
                                    ]
                                ]
                            ],
                            [
                                'chapter_number' => 7,
                                'content' => 'L\'air frais du parc est comme une gorgée d\'eau fraîche pour ton esprit assoiffé. Les feuilles bruissent doucement au-dessus de toi, créant une symphonie naturelle qui apaise tes pensées agitées. Tu as laissé ton téléphone en mode avion, créant une bulle temporelle où les emails et les rappels n\'existent pas. Pendant une heure, tu n\'es plus un étudiant submergé, mais simplement un humain qui respire. Tu observes un écureuil zigzaguer entre les arbres, totalement absorbé par l\'instant présent, sans se soucier du passé ou du futur. Une leçon silencieuse de sa part. Quand tu reprends le chemin de chez toi, quelque chose a changé. Pas tes obligations - elles t\'attendent, immuables. C\'est ton regard qui s\'est transformé. Comme si tu avais ajusté la mise au point d\'un appareil photo, voyant enfin clairement ce qui était flou.',
                                'stress_level' => 0,
                                'stress_impact' => 1,
                                'stress_advice' => 'La pleine conscience et la connexion avec la nature peuvent être des outils puissants de gestion du stress.',
                                'choices' => [
                                    [
                                        'text' => 'Transformer ce moment de repos en opportunité de réflexion profonde.',
                                        'stress_impact' => 0,
                                        'stress_advice' => 'La réflexion consciente peut aider à comprendre et gérer le stress.',
                                        'next_chapter_number' => 12
                                    ],
                                    [
                                        'text' => 'Continuer à t\'accorder du temps sans culpabilité.',
                                        'stress_impact' => 1,
                                        'stress_advice' => 'S\'accorder du temps pour soi est essentiel à la santé mentale.',
                                        'next_chapter_number' => 13
                                    ]
                                ]
                            ],
                            [
                                'chapter_number' => 8,
                                'content' => 'Le bureau de ton professeur est encombré de livres et de papiers, des strates de connaissances accumulées comme des couches géologiques. Il t\'écoute attentivement, sans jugement dans son regard. "Je comprends," dit-il quand tu finis d\'expliquer ta situation. Ces deux mots simples agissent comme un baume sur ton anxiété. "Voici ce que je propose..." Il esquisse un plan, un chemin à travers ce qui semblait être une forêt impénétrable. Tu prends des notes frénétiquement, chaque point comme une bouée de sauvetage. En sortant de son bureau, le couloir semble plus lumineux qu\'avant. Le poids sur tes épaules n\'a pas disparu, mais il s\'est allégé, devenu gérable. Tu te diriges vers la bibliothèque avec un objectif clair, comme un navigateur qui a enfin trouvé son étoile polaire après une nuit de brouillard.',
                                'stress_level' => 1,
                                'stress_impact' => 1,
                                'stress_advice' => 'Demander de l\'aide et être accompagné peut réduire considérablement le stress.',
                                'choices' => [
                                    [
                                        'text' => 'Intégrer les conseils reçus et prendre un jour pour restructurer ton approche.',
                                        'stress_impact' => 0,
                                        'stress_advice' => 'La planification et l\'organisation peuvent apporter de la sérénité.',
                                        'next_chapter_number' => 14
                                    ],
                                    [
                                        'text' => 'Négocier des délais supplémentaires pour préserver ta santé mentale.',
                                        'stress_impact' => 2,
                                        'stress_advice' => 'Communiquer ses limites est un acte de courage et d\'auto-préservation.',
                                        'next_chapter_number' => 10
                                    ]
                                ]
                            ],
                            [
                                'chapter_number' => 9,
                                'content' => 'Le soleil se lève sur un nouveau jour, et avec lui, une nouvelle façon d\'aborder ton travail. Tu as divisé la montagne en collines, segmenté le marathon en sprints gérables. Sur ton mur, un tableau visuel affiche tes priorités - non plus comme une liste accusatrice, mais comme une carte routière. Les tâches urgentes sont en rouge, les importantes en orange, les secondaires en vert. Chaque post-it déplacé dans la colonne "terminé" est une petite victoire célébrée. Tu as installé une application qui te rappelle de faire des pauses, de boire de l\'eau, de t\'étirer. Ton corps et ton esprit ne sont plus des adversaires dans cette bataille, mais des alliés qui travaillent en harmonie. L\'anxiété n\'a pas disparu - elle rode toujours, comme une ombre à la périphérie de ta vision - mais elle n\'est plus aux commandes.',
                                'stress_level' => 2,
                                'stress_impact' => 1,
                                'stress_advice' => 'La création de systèmes et de routines peut aider à réduire le stress mental.',
                                'choices' => [
                                    [
                                        'text' => 'Cultiver cette nouvelle conscience et l\'appliquer à tous les aspects de ta vie.',
                                        'stress_impact' => 0,
                                        'stress_advice' => 'La conscience de soi est la première étape vers la gestion du stress.',
                                        'next_chapter_number' => 15
                                    ],
                                    [
                                        'text' => 'Rassembler une équipe de soutien pour les défis à venir.',
                                        'stress_impact' => 1,
                                        'stress_advice' => 'Un réseau de soutien peut être un bouclier contre le stress.',
                                        'next_chapter_number' => 10
                                    ]
                                ]
                            ],
                            [
                                'chapter_number' => 10,
                                'content' => 'Le vendredi arrive comme la ligne d\'arrivée d\'une course d\'endurance. Tes muscles mentaux sont endoloris, mais tu ressens cette fatigue particulière qui vient de l\'accomplissement, pas de l\'épuisement vide. Tu regardes ton bureau, autrefois champ de bataille, maintenant terrain conquis. Les deadlines ont été respectées, les travaux rendus, les emails traités. Tu as navigué à travers cette semaine tempétueuse sans chavirer. En réfléchissant, tu réalises que ce n\'est pas tant la quantité de travail qui a changé, mais ta façon de l\'aborder. Tu as appris à reconnaître les signes avant-coureurs du burnout, à respecter tes limites sans te juger. Cette leçon, plus que n\'importe quel cours théorique, restera avec toi. En fermant ton ordinateur, tu ressens quelque chose qui ressemble à de la fierté. Pas seulement pour ce que tu as accompli, mais pour qui tu es devenu à travers ces épreuves.',
                                'stress_level' => 1,
                                'stress_impact' => 1,
                                'stress_advice' => 'Prendre du recul et reconnaître ses progrès est essentiel à la gestion du stress.',
                                'choices' => [
                                    [
                                        'text' => 'Formaliser tes apprentissages dans un journal de réflexion personnel.',
                                        'stress_impact' => 0,
                                        'stress_advice' => 'La réflexion et l\'écriture peuvent être des outils puissants de gestion émotionnelle.',
                                        'next_chapter_number' => 15
                                    ],
                                    [
                                        'text' => 'Célébrer tes victoires et planifier ton prochain défi avec confiance.',
                                        'stress_impact' => 2,
                                        'stress_advice' => 'Célébrer ses succès peut recharger la motivation et réduire le stress.',
                                        'next_chapter_number' => null
                                    ]
                                ]
                            ],
                            [
                                'chapter_number' => 11,
                                'content' => 'Le lundi suivant arrive avec son lot de nouveaux défis. Tu te retrouves face à un projet de groupe inattendu, annoncé à la dernière minute par un professeur qui semble ignorer que vous avez d\'autres cours. Autour de toi, tes camarades échangent des regards paniqués. Mais toi, étrangement, tu restes calme. Tu observes cette tempête émotionnelle collective comme un météorologue observe un orage - avec curiosité plutôt qu\'avec peur. "On pourrait se retrouver à la bibliothèque ce soir pour commencer," proposes-tu au groupe. Tes mots surprennent même tes propres oreilles. D\'où vient cette assurance? Cette capacité à transformer l\'obstacle en opportunité? Un sourire se dessine sur ton visage alors que tu réalises: la semaine dernière t\'a transformé. Les épreuves traversées ont forgé en toi quelque chose de nouveau, comme une épée trempée dans le feu qui en ressort plus forte.',
                                'stress_level' => 3,
                                'stress_impact' => 2,
                                'stress_advice' => 'La résilience se construit à travers les défis. Chaque nouvelle situation est une opportunité d\'apprentissage.',
                                'choices' => [
                                    [
                                        'text' => 'Utiliser cette expérience pour développer tes compétences de leadership.',
                                        'stress_impact' => 1,
                                        'stress_advice' => 'Le leadership peut être un outil puissant de gestion du stress collectif.',
                                        'next_chapter_number' => 13
                                    ],
                                    [
                                        'text' => 'Explorer des méthodes alternatives de gestion du stress.',
                                        'stress_impact' => 2,
                                        'stress_advice' => 'La recherche active de stratégies de gestion du stress est un signe de maturité émotionnelle.',
                                        'next_chapter_number' => 12
                                    ]
                                ]
                            ],
                            [
                                'chapter_number' => 12,
                                'content' => 'La réunion de groupe s\'éternise, les voix se chevauchent comme des vagues désordonnées. Chacun défend son idée, personne n\'écoute vraiment. L\'horloge murale semble narguer ton emploi du temps soigneusement planifié. Une heure perdue, puis deux. La frustration monte en toi comme une marée, menaçant d\'engloutir ta patience fraîchement acquise. Tu sens le stress ancien qui frappe à la porte de ton esprit, demandant à être réadmis. Tes mains tremblent légèrement sous la table, tes tempes palpitent au rythme d\'un métronome affolé. Autour de toi, les discussions stériles continuent. Un choix s\'impose: reprendre le contrôle de la situation ou laisser l\'anxiété reprendre les commandes. Dans cette salle surchauffée où l\'air devient rare, tu te retrouves à un carrefour familier. La voie que tu choisiras maintenant pourrait définir non seulement l\'issue de ce projet, mais aussi ton rapport au stress pour les semaines à venir.',
                                'stress_level' => 6,
                                'stress_impact' => 3,
                                'stress_advice' => 'Quand le stress devient envahissant, il est crucial de retrouver son calme intérieur.',
                                'choices' => [
                                    [
                                        'text' => 'Prendre en main la situation difficile avec une approche structurée.',
                                        'stress_impact' => 2,
                                        'stress_advice' => 'La structure peut être un bouclier contre le chaos et le stress.',
                                        'next_chapter_number' => 14
                                    ],
                                    [
                                        'text' => 'Rechercher un équilibre en déléguant certaines responsabilités.',
                                        'stress_impact' => 3,
                                        'stress_advice' => 'Savoir déléguer est un signe de force, pas de faiblesse.',
                                        'next_chapter_number' => 15
                                    ]
                                ]
                            ],
                            [
                                'chapter_number' => 13,
                                'content' => 'Tu te lèves calmement, attirant l\'attention du groupe. "J\'ai une proposition," dis-tu d\'une voix posée qui contraste avec le chaos précédent. Tu exposes un plan structuré, divisant le projet en sections distinctes, assignant des tâches selon les forces de chacun. Tes mots créent une architecture dans l\'air, un échafaudage sur lequel vos idées dispersées peuvent enfin s\'accrocher. Le groupe se tait, surpris par cette clarté soudaine. Un à un, ils acquiescent, soulagés que quelqu\'un prenne l\'initiative. En sortant de la réunion, tu reçois des remerciements sincères. "Comment fais-tu pour rester si calme?" te demande une camarade. Tu réfléchis un instant. La vérité est que tu n\'es pas calme à l\'intérieur - le stress est toujours là, comme une rivière sous la glace. Mais tu as appris à naviguer avec lui plutôt que contre lui. "C\'est une pratique quotidienne," réponds-tu simplement. Sur le chemin du retour, le ciel s\'assombrit, promettant de la pluie. Pourtant, tu te sens étrangement ensoleillé.',
                                'stress_level' => 4,
                                'stress_impact' => 2,
                                'stress_advice' => 'Le leadership peut être un outil puissant de gestion du stress collectif.',  
                                'choices' => [
                                    [
                                        'text' => 'Approfondir ta pratique de pleine conscience au quotidien.',
                                        'stress_impact' => 0,
                                        'stress_advice' => 'La pleine conscience peut aider à maintenir un équilibre mental durable.',
                                        'next_chapter_number' => 15
                                    ],
                                    [
                                        'text' => 'Partager tes découvertes avec d\'autres personnes stressées.',  
                                        'stress_impact' => 1,
                                        'stress_advice' => 'Partager son expérience peut aider à inspirer et soutenir les autres.',
                                        'next_chapter_number' => 14
                                    ]
                                ]
                            ],
                            [
                                'chapter_number' => 14,
                                'content' => 'La nuit est profonde lorsque tu enregistres enfin le dernier fichier de ton projet. Autour de toi, l\'appartement est plongé dans un silence rassurant, seulement troublé par le cliquetis régulier du clavier et le souffle discret du réfrigérateur. Une tasse de thé à moitié vide refroidit lentement à côté de ton écran, témoin discret des heures qui se sont écoulées. Tu t\'étires lentement, les épaules tendues, les paupières lourdes, mais une étrange sérénité te traverse. Ce n\'est pas l\'euphorie épuisante d\'une nuit blanche, mais une énergie calme et maîtrisée. Tu te lèves et ouvres la fenêtre : l\'air nocturne caresse ton visage, et les lumières de la ville scintillent comme des balises de vie silencieuse. Une pensée t\'effleure : tu n\'es pas seul à affronter des défis. Il y a, quelque part, d\'autres âmes éveillées, tout aussi engagées dans leur propre lutte. Et ce simple constat te relie à quelque chose de plus grand. Pour la première fois depuis longtemps, le futur ne t\'angoisse pas — il t\'inspire.',
                                'stress_level' => 3,
                                'stress_impact' => 1,
                                'stress_advice' => 'La connexion avec les autres peut donner un sens de perspective et réduire le stress.',
                                'choices' => [
                                    [
                                        'text' => 'Intégrer définitivement ces pratiques dans ta routine quotidienne.',
                                        'stress_impact' => 0,  
                                        'stress_advice' => 'Transformer les leçons en habitudes est essentiel pour une résilience durable.',
                                        'next_chapter_number' => 15
                                    ],
                                    [
                                        'text' => 'Chercher à approfondir ta compréhension des mécanismes du stress.',
                                        'stress_impact' => 2,
                                        'stress_advice' => 'La curiosité intellectuelle peut mener à une meilleure gestion émotionnelle.',  
                                        'next_chapter_number' => null
                                    ]  
                                ]
                            ],
                            [
                                'chapter_number' => 15,
                                'content' => 'Le semestre touche à sa fin, et avec lui, une période de transformation personnelle. Tu ranges tes livres dans ton sac pour la dernière fois, savourant le poids familier sur ton épaule. Autour de toi, le campus bourdonne d\'une énergie particulière - un mélange d\'euphorie post-examens et de mélancolie anticipée. Tu traverses la pelouse où tu t\'es si souvent assis pour réviser, où tu as ri avec tes amis, où tu as parfois douté de toi-même. Chaque pas est comme un écho de tes expériences. Tu réalises que le plus grand défi n\'était pas académique. C\'était d\'apprendre à naviguer les eaux tumultueuses de ta propre psyché, de faire face à tes peurs et de les transformer en forces. Tu as appris que le burnout n\'est pas une fatalité, mais une opportunité de se réinventer. Et cette leçon, plus que toute autre, restera gravée en toi bien après que ces murs seront derrière toi. Tu souris à cette pensée. L\'avenir est incertain, mais pour la première fois, cette incertitude est exaltante.',
                                'stress_level' => 2,  
                                'stress_impact' => 0,
                                'stress_advice' => 'Prendre le temps de réfléchir sur son parcours peut renforcer le sentiment de croissance personnelle.',
                                'choices' => []
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