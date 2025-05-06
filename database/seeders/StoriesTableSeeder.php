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
                'title' => 'Batterie Mentale',
                'summary' => 'Cette histoire interactive suit le parcours d\'un étudiant en ingénierie des médias à la HEIG-VD qui navigue entre projets, cours et vie personnelle. Chaque chapitre présente une situation et des choix possibles qui influencent le niveau de stress, le sommeil et les notes du protagoniste.',
                'chapters' => [
                    [
                        'chapter_number' => 1,
                        'content' => 'Ce lundi matin, ton réveil hurle à 6h30 comme une alarme de fin du monde. Tes yeux s\'ouvrent difficilement dans ta chambre d\'étudiant à Yverdon. Tu fixes le plafond, accablé par la liste mentale qui se déroule déjà: le projet de développement web dont le deadline est vendredi, la présentation de Visualisation de données cette après-midi, et cet exercice de programmation que tu n\'as pas terminé. La HEIG-VD n\'est pas réputée pour être facile, mais la filière Ingénierie des Médias semble avoir concentré toutes ses évaluations cette semaine.
                        Ton téléphone vibre: un message de ton groupe de projet qui panique déjà à 6h30 du matin. "Est-ce que quelqu\'un a réussi le déploiement sur le serveur?" Tu sens une boule se former dans ton estomac. L\'envie de te rendormir est tentante, mais l\'angoisse est là. Tu pourrais sauter le petit-déjeuner et te précipiter directement sur ton ordinateur pour avancer, ou prendre 15 minutes pour manger correctement et respirer avant d\'affronter cette journée.',
                        'stress_advice' => ' "Le matin définit souvent le rythme de ta journée. Prendre quelques minutes pour toi n\'est pas du temps perdu."',
                        'sleep_advice' => '"Un bon petit-déjeuner aide ton cerveau à se réveiller, même après une nuit difficile."',
                        'grades_advice' => '"Commencer la journée calmement permet de mieux organiser ses priorités académiques."',
                        'choices' => [
                            [
                                'text' => 'Te lever, sauter le petit-déj et foncer directement dans ton ordinateur.',
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
                        'content' => 'Tu arrives à la HEIG avec quelques minutes de retard, ton café à emporter à moitié renversé sur ta veste. La salle T102 est plongée dans la pénombre, le cours de Data Visualization déjà commencé. Tu te glisses discrètement au fond, tandis que la prof projette des graphiques complexes que tu n\'arrives pas à décoder dans la précipitation.

                        Tu as manqué l\'introduction et maintenant rien n\'a de sens. Ton estomac gronde — le café à lui seul ne remplace pas un petit-déjeuner. Quand la prof mentionne "ce sera bien sûr dans l\'examen de vendredi", tu sens ton cœur s\'accélérer. Ton ordinateur s\'allume péniblement alors que tous les autres semblent déjà plongés dans l\'exercice pratique de D3.
                        
                        Des dizaines de notifications non lues s\'affichent: 36 messages dans le groupe du projet D3, 5 teams des professeurs, et une alerte du système de rendu: "Attention: il vous reste 3 jours pour soumettre votre projet final."',
                        'stress_impact' => 1,
                        'sleep_impact' => 0,
                        'grades_impact' => 0,
                        'is_recovery_point' => false,
                        'stress_advice' => "La précipitation constante est l'ennemie de la concentration. Parfois, un pas en arrière permet d'en faire deux en avant.",
                        'sleep_advice' => "Le manque de petit-déjeuner et l'excès de caféine perturbent ton cycle de sommeil, même si tu ne le sens pas immédiatement.",
                        'grades_advice' => "Arriver en retard te fait manquer des informations cruciales pour comprendre la matière.",
                        'choices' => [
                            [
                                'text' => 'Commander un second café à la cafétéria et essayer de rattraper le cours coûte que coûte.',
                                'next_chapter_number' => 4
                            ],
                            [
                                'text' => 'Sortir discrètement faire une courte pause pour éclaircir tes idées.',
                                'next_chapter_number' => 5
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 3,
                        'content' => 'Tu as pris le temps de respirer et de te recentrer. Assis sur un banc du campus St-Roch de la HEIG-VD, tu observes les montagnes au loin. L\'air frais du matin emplit tes poumons, et tu réalises combien ce simple moment est précieux.

                        Tu sors ton carnet et notes les priorités réelles de la journée: d\'abord terminer l\'exercice de Dév Prod Méd (2 heures maximum), puis consacrer l\'après-midi au projet de groupe après la présentation. Le reste peut attendre demain.
                        
                        Le stress ne disparaît pas complètement, mais il devient gérable. Ton téléphone continue de vibrer, mais tu décides consciemment de ne pas vérifier chaque notification. Ce n\'est pas la fin du monde si tu ne réponds pas immédiatement à tous ces messages.
                        
                        En organisant mentalement ta journée, les tâches semblent moins écrasantes. "Une chose à la fois", te répètes-tu.',
                        'stress_impact' => -1, 
                        'sleep_impact' => 0,
                        'grades_impact' => 0,
                        'stress_advice' => '"La gestion du temps commence par définir consciemment ce qui mérite ton attention immédiate."',
                        'sleep_advice' => '"Les pauses régulières améliorent la qualité de ton sommeil la nuit suivante."',
                        'grades_advice' => '"Savoir prioriser les tâches académiques est souvent plus efficace que de tout faire en même temps."',
                        'choices' => [
                            [
                                'text' => ' Ouvrir ton agenda et organiser méthodiquement tes tâches pour la semaine. ',
                                'next_chapter_number' => 5
                            ],
                            [
                                'text' => 'Jeter un œil à Instagram "juste 5 minutes" pour te détendre un peu plus. ',
                                'next_chapter_number' => 6
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 4,
                        'content' => 'Le deuxième café de la matinée fait battre ton cœur à un rythme inquiétant. Tes mains tremblent légèrement sur ton clavier tandis que tu essaies désespérément de rattraper le cours. La prof de Data Visualization parle maintenant d\'une nouvelle bibliothèque JavaScript dont tu n\'as jamais entendu parler, et tout le monde autour semble comprendre parfaitement.

                        Une notification de Calendar apparaît: réunion de projet pour le cours de Proposition de Valeur dans 45 minutes, et tu n\'as pas préparé ta partie. Ton binôme t\'envoie un message direct: "T\'as fini le Business Model Canva? Je dois l\'avoir pour finir ma partie."
                        
                        Ton écran se divise entre le cours auquel tu essaies de participer et les messages de plus en plus anxieux de ton équipe. Ta capacité à te concentrer s\'effrite. Ta gorge se serre et tu as l\'impression que la salle de cours rétrécit autour de toi.',
                        'stress_impact' => 2,
                        'sleep_impact' => -1,
                        'grades_impact' => -1,
                        'stress_advice' => '"La multitâche est un mythe. Ton cerveau ne peut pas se concentrer efficacement sur plusieurs tâches complexes simultanément."',
                        'sleep_advice' => '"La surcharge de caféine perturbe gravement ton sommeil et peut créer un cercle vicieux de fatigue et d\'anxiété."',
                        'grades_advice' => '"Disperser ton attention entre plusieurs tâches garantit que tu ne feras aucune d\'elles correctement."',
                        'choices' => [
                            [
                                'text' => 'Ignorer le cours et travailler frénétiquement sur le projet pour tenir les délais.',
                                'next_chapter_number' => 7
                            ],
                            [
                                'text' => 'Fermer toutes les applications sauf une et te concentrer uniquement sur le cours présent. ',
                                'next_chapter_number' => 5
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 5,
                        'content' => 'Maintenant, tu décides de t\'installes dans l\'espace d\'étude du deuxième étage, ton ordinateur ouvert devant toi. Plutôt que de réagir à chaque notification, tu as désactivé les alertes et ouvert un document avec trois colonnes: "Urgent", "Important", "Peut attendre".

                        En classant tes tâches, tu réalises que beaucoup de choses peuvent attendre demain. Tu identifies les deux actions critiques pour aujourd\'hui: finaliser ton Business Model Canva le projet de groupe, et préparer les points clés pour la présentation de cet après-midi.
                        
                        Le simple fait d\'avoir un plan clair allège ton esprit. Tu commences par la tâche la plus complexe, en te donnant 90 minutes de concentration totale. Tu places ton téléphone en mode avion et mets tes écouteurs.
                        
                        Pour la première fois de la journée, ton esprit se focalise pleinement sur une seule chose à la fois.',
                        'stress_impact' => 0,
                        'sleep_impact' => 1,
                        'grades_impact' => -1,
                        'stress_advice' => '"La clarté des priorités est le premier pas vers la productivité sereine."',
                        'sleep_advice' => '"L\'organisation réduit l\'anxiété nocturne qui perturbe l\'endormissement."',
                        'grades_advice' => '"La qualité du travail profond sur une seule tâche surpasse toujours la quantité du travail superficiel sur plusieurs tâches."',
                        'choices' => [
                            [
                                'text' => 'Continuer à travailler méthodiquement, avec des pauses planifiées.',
                                'next_chapter_number' => 8
                            ],
                            [
                                'text' => 'Accepter de dépanner un autre groupe qui te demande de l\'aide en urgence.',
                                'next_chapter_number' => 6
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 6,
                        'content' => 'Tu finis par scroller sur TikTok, et les "5 minutes" se transforment en 40. Des vidéos de voyage, de cuisine, et ironiquement, des conseils de productivité défilent sans que tu ne t\'en rendes compte. Lorsque tu reprends conscience du temps qui passe, une vague d\'anxiété te submerge.

                        Tu regardes l\'heure: 11h20. La réunion de projet est dans 10 minutes et tu n\'as rien préparé. Tu ouvres frénétiquement ton Miro, mais ton cerveau peine à se reconcentrer.
                        
                        Trois membres de ton groupe de projet t\'ont envoyé des messages personnels, s\'inquiétant de ton silence. Ton téléphone sonne: c\'est le responsable du projet qui te demande si tout va bien. Tu bafouilles une excuse en promettant que tout sera prêt.
                        
                        Un sentiment d\'imposture te gagne. Comment as-tu pu perdre autant de temps? Tu tentes de travailler sur plusieurs fichiers simultanément, sautant d\'une tâche à l\'autre sans vraiment en terminer aucune.',
                        'stress_impact' => 3,
                        'sleep_impact' => -2,
                        'grades_impact' => -2,
                        'stress_advice' => '"La procrastination n\'est pas un problème de gestion du temps, mais de gestion des émotions face aux tâches difficiles."',
                        'sleep_advice' => '"L\'anxiété accumulée pendant la journée se manifeste souvent la nuit sous forme d\'insomnie ou de sommeil agité."',
                        'grades_advice' => '"Les réseaux sociaux sont conçus pour capter ton attention, exactement comme ils l\'ont fait aujourd\'hui, au détriment de ton travail académique."',
                        'choices' => [
                            [
                                'text' => ' Enchaîner les boissons énergisantes pour tenir le rythme et travailler jusqu\'à très tard.',
                                'next_chapter_number' => 7
                            ],
                            [
                                'text' => 'Admettre ton retard, t\'excuser, et te concentrer sur une seule tâche prioritaire.',
                                'next_chapter_number' => 8
                            ]
                        ]
                    ],
                    
                    
                    [
                        'chapter_number' => 7,
                        'content' => 'Ton cœur bat la chamade. Il est 16h, la journée n\'est pas terminée, mais ton corps semble au bord de la rupture. Dans le laboratoire d\'informatique de la HEIG, tu fixes ton écran où les lignes de code commencent à se brouiller devant tes yeux fatigués.

                        Tu as enchaîné trois Red Bull depuis ce matin. Tes mains tremblent sur le clavier. Une migraine s\'installe derrière tes yeux, et tu remarques que tu serres tellement la mâchoire que ton visage te fait mal.
                        
                        Ta présentation s\'est mal passée. Tu as oublié des éléments clés et bafouillé aux questions du professeur. L\'explication de ton algorithme était confuse, tu le sais. Et maintenant, le projet de groupe semble prendre encore plus de retard.',
                        'stress_impact' => 2,
                        'sleep_impact' => -3,
                        'grades_impact' => 0,
                        'stress_advice' => '"Ton corps t\'envoie des signaux d\'alarme bien avant le point de rupture. Apprends à les reconnaître."',
                        'sleep_advice' => '"La caféine et les boissons énergisantes provoquent un effondrement du système nerveux après leur effet temporaire."',
                        'grades_advice' => '"Un esprit épuisé ne peut pas produire un travail de qualité, ce qui se reflète dans tes notes."',
                        'choices' => [
                            [
                                'text' => 'Prendre une pilule de caféine concentrée offerte par un camarade pour tenir jusqu\'à la fin. ',
                                'next_chapter_number' => 9
                            ],
                            [
                                'text' => 'Admettre que tu as besoin d\'air et sortir marcher dix minutes autour du campus.',
                                'next_chapter_number' => 8
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 8,
                        'content' => 'Tu marches autour du centre St-Roch, le vent frais de Yverdon sur ton visage. Pour la première fois de la journée, tu prends une vraie respiration profonde, remplissant tes poumons d\'air frais. Le lac brille au loin.

                        Tu t\'assieds sur un banc et fermes les yeux un instant, pratiquant une technique de respiration que ton ami t\'a montrée. Quatre secondes d\'inspiration, rétention quatre secondes, expiration six secondes.
                        
                        Après quelques cycles, ton esprit s\'éclaircit suffisamment pour réaliser l\'évidence: tu ne peux pas tout faire parfaitement. Personne ne le peut. Tu prends une décision: plutôt que de tout faire médiocrement, tu vas choisir ce qui est vraiment essentiel et le faire correctement.
                        
                        Tu envoies un message honnête à ton groupe: "J\'ai pris du retard, je me concentre sur la fonctionnalité principale pour ce soir. Les améliorations viendront demain."',
                        'stress_impact' => -2, 
                        'sleep_impact' => 2,
                        'grades_impact' => 1,
                        'stress_advice' => '"L\'honnêteté envers toi-même et les autres est libératrice. Personne n\'est surhumain."',
                        'sleep_advice' => '"L\'exercice physique léger comme la marche aide à réguler les hormones du stress qui perturbent le sommeil."',
                        'grades_advice' => '"Savoir reconnaître ses limites et communiquer honnêtement est une compétence professionnelle valorisée par les enseignants."',
                        'choices' => [
                            [
                                'text' => 'Retourner à l\'intérieur avec un plan clair pour la soirée et le reste de la semaine.',
                                'next_chapter_number' => 9
                            ],
                            [
                                'text' => 'Te laisser convaincre par un camarade de rejoindre une session de codage nocturne pour rattraper tout le retard d\'un coup.',
                                'next_chapter_number' => 10
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 9,
                        'content' => 'Tu t\'installes à la bibliothèque avec un nouvel état d\'esprit. Ton ordinateur est ouvert, mais cette fois, seule une application fonctionne: Visual Studio Code, concentré sur la tâche principale.

                        Ton plan est simple: deux heures de travail ciblé sur l\'API backend que ton groupe attend. Pas de réseaux sociaux, pas d\'emails, juste du code. Tu as même mis une minuterie: 25 minutes de travail, 5 minutes de pause.
                        
                        Les premières lignes sont difficiles, mais progressivement, le flow s\'installe. Les fonctions s\'enchaînent, les tests passent au vert. À ta pause, tu t\'étires et regardes par la fenêtre, plutôt que de vérifier ton téléphone.
                        
                        Tu sens une satisfaction profonde, différente de l\'agitation fébrile de ce matin. Ce n\'est pas l\'euphorie, mais plutôt une tranquillité productive, comme si tu avais retrouvé ton rythme naturel.',
                        'stress_impact' => -1, 
                        'sleep_impact' => 0,
                        'grades_impact' => 0,
                        'stress_advice' => ' "Le véritable état de flow vient d\'un équilibre entre défi et compétence, pas de la pression excessive."',
                        'sleep_advice' => '"Le travail satisfaisant et bien cadré en journée favorise un sommeil profond et réparateur la nuit."',
                        'grades_advice' => '"La technique Pomodoro (25 min de travail, 5 min de pause) est scientifiquement prouvée pour améliorer la qualité et la rétention du travail académique."',
                        'choices' => [
                            [
                                'text' => 'Envoyer ton travail au groupe et décider de rentrer à une heure raisonnable ce soir.',
                                'next_chapter_number' => 11
                            ],
                            [
                                'text' => ' Profiter de cet élan pour ajouter une dizaine de fonctionnalités bonus que tu avais envisagées.',
                                'next_chapter_number' => 10
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 10,
                        'content' => 'Tu as réussi à maintenir ton rythme équilibré pendant deux jours. Les membres de ton groupe de PropVal remarquent le changement: tes contributions sont plus ciblées et tu communiques plus clairement.

                        À la fin du cours de Proposition de valeur, ton professeur te retient: "Ton groupe avance bien sur le projet principal. J\'ai une opportunité pour toi — un hackathon à la RTS ce weekend. C\'est une chance de te faire remarquer."
                        
                        Une partie de toi s\'enthousiasme à l\'idée. C\'est exactement le genre d\'occasion qui pourrait enrichir ton CV. Mais une autre partie de toi se souvient de l\'état dans lequel tu étais il y a deux jours, et se demande si c\'est raisonnable d\'ajouter cela à ta charge de travail.
                        
                        Tu regardes ton planning de la semaine: il reste deux projets à finaliser, et tu commences tout juste à retrouver un rythme de sommeil normal.',
                        'stress_impact' => 0, 
                        'sleep_impact' => 0,
                        'grades_impact' => 0,
                        'stress_advice' => ' "Les opportunités sont infinies, mais ton énergie et ton temps ne le sont pas. Choisir, c\'est aussi renoncer."',
                        'sleep_advice' => '"Parfois, dire non aujourd\'hui te permet de dire oui à de meilleures opportunités demain, avec plus d\'énergie."',
                        'grades_advice' => '"Les professeurs respectent les étudiants qui connaissent leurs limites et savent gérer leur charge de travail."',
                        'choices' => [
                            [
                                'text' => 'Refuser poliment l\'invitation au hackathon en expliquant que tu dois gérer ta charge actuelle.',
                                'next_chapter_number' => 11
                            ],
                            [
                                'text' => 'Accepter le hackathon avec enthousiasme — tu dormiras la semaine prochaine!',
                                'next_chapter_number' => 12
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 11,
                        'content' => '"J\'apprécie vraiment cette opportunité, Professeur, mais je dois décliner. Je me suis engagé à livrer un travail de qualité sur mes projets actuels, et je dois respecter mes limites."

                        Les mots sortent de ta bouche avec une assurance qui te surprend toi-même. Le professeur te regarde un moment, puis hoche la tête avec ce qui ressemble à du respect. "C\'est une décision mature. Le hackathon reviendra, ne t\'inquiète pas."
                        
                        En quittant le bâtiment, tu ressens un mélange étrange de soulagement et de légère déception. As-tu raté une opportunité? Peut-être. Mais en marchant vers ton appartement, tu réalises que tu viens de faire quelque chose d\'important: établir une limite saine.
                        
                        Ce soir, tu as le temps de préparer un vrai repas au lieu de manger un sandwich devant ton ordinateur. Tu prends même une heure pour appeler tes parents, qui s\'étonnent de t\'entendre si détendu en pleine période de projets.',
                        'stress_impact' => 1,
                        'sleep_impact' => 0,
                        'grades_impact' => 0,
                        'stress_advice' => '"Dire non à certaines choses te permet de dire un oui plus engagé à d\'autres."',
                        'sleep_advice' => '"Une soirée détendue sans écrans avant le coucher améliore considérablement la qualité du sommeil."',
                        'grades_advice' => '"La constance dans la qualité du travail vaut mieux que des pics d\'excellence suivis d\'épuisement."',
                        'choices' => [
                            [
                                'text' => 'Maintenir ce cap et accorder autant d\'importance à ton bien-être qu\'à tes études.',
                                'next_chapter_number' => 13
                            ],
                            [
                                'text' => 'Compenser ton refus en redoublant d\'efforts sur tes projets actuels pour prouver ta valeur. ',
                                'next_chapter_number' => 12
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 12,
                        'content' => 'Les jours passent et ton agenda déborde. Entre les cours à la HEIG, le hackathon que tu as accepté, et ton projet principal, chaque minute est comptée. Tu dors à peine 5 heures par nuit, et ton alimentation se résume à des snacks pris sur le pouce.

                        Ta performance reste correcte, mais tu remarques que ton esprit n\'est plus aussi vif. Lors d\'une présentation de groupe en UX, tu perds le fil de tes idées plusieurs fois. Un camarade doit intervenir pour terminer ton explication.
                        
                        Dans les couloirs, tu croises un étudiant de troisième année qui te lance: "Ça va? T\'as une tête à faire peur." Tu balaies la remarque d\'un revers de main, mais en te regardant dans le miroir des toilettes, tu ne reconnais pas le visage épuisé qui te fixe.
                        
                        Ce soir, le professeur de développement web a proposé une session facultative de révision avancée. Tu hésites — ton corps te supplie de rentrer dormir, mais tu crains de prendre du retard.',
                        'stress_impact' => 2,
                        'sleep_impact' => -3,
                        'grades_impact' => 0,
                        'stress_advice' => '"L\'excellence soutenue nécessite des périodes de récupération. Même les athlètes d\'élite programment des jours de repos."',
                        'sleep_advice' => '"Les recherches montrent qu\'après 16 heures d\'éveil, tes capacités cognitives sont équivalentes à celles d\'une personne légalement ivre."',
                        'grades_advice' => '"La mémoire à long terme, essentielle pour les examens, se consolide pendant le sommeil profond que tu n\'as pas en ce moment."',
                        'choices' => [
                            [
                                'text' => 'Ignorer tous les signaux d\'alerte et assister à la session supplémentaire.',
                                'next_chapter_number' => null
                            ],
                            [
                                'text' => 'Écouter ton corps et rentrer te reposer, même si cela signifie manquer une opportunité.',
                                'next_chapter_number' => 13
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 13,
                        'content' => 'C\'est vendredi après-midi, la semaine touche à sa fin. Tu es assis dans le parc à côté de la HEIG, relisant les notes de la dernière réunion de projet. Le soleil filtre à travers les feuilles des arbres, projetant des motifs changeants sur ton cahier.

                        Ces derniers jours, tu as maintenu une discipline étonnante: 7 heures de sommeil par nuit, des repas pris loin de ton ordinateur, et surtout, des limites claires entre travail et repos. Tu as même recommencé à courir le matin, juste 20 minutes, mais suffisamment pour éclaircir ton esprit.
                        
                        Tes notes de cours sont plus organisées, tes contributions au projet plus pertinentes. La quantité de travail n\'a pas diminué, mais ta façon de l\'aborder a changé. Tu ne réagis plus dans l\'urgence constante.
                        
                        Un camarade de classe passe et s\'arrête: "Comment tu fais pour rester si calme avec tous ces deadlines? T\'as un secret?"',
                        'stress_impact' => -2, 
                        'sleep_impact' => 2,
                        'grades_impact' => 2,
                        'stress_advice' => '"Le vrai secret de la productivité n\'est pas de faire plus, mais de récupérer mieux."',
                        'sleep_advice' => '"L\'exercice matinal régule les hormones du sommeil et améliore la qualité de ton repos nocturne."',
                        'grades_advice' => '"La régularité dans l\'effort est la clé d\'une réussite académique durable."',
                        'choices' => [
                            [
                                'text' => 'Partager avec lui tes techniques de gestion du stress et d\'organisation.',
                                'next_chapter_number' => 14
                            ],
                            [
                                'text' => 'Minimiser tes progrès et te remettre immédiatement au travail par peur de trop te relâcher. ',
                                'next_chapter_number' => 12
                            ]
                        ]
                    ],
                    [
                        'chapter_number' => 14,
                        'content' => '"En fait, j\'ai juste appris à respecter mes limites," expliques-tu à ton camarade. Vous vous asseyez sur un banc et tu lui montres ton système simple: un agenda où chaque tâche est délibérément planifiée avec du temps tampon, des périodes de récupération clairement marquées en vert, et une liste de priorités quotidiennes limitée à trois éléments maximum.

                        "Le truc, c\'est que je n\'essaie plus d\'être parfait dans tout. J\'ai choisi les domaines où je veux vraiment exceller, et pour le reste, je vise juste la compétence correcte."
                        
                        Ton camarade prend des notes, visiblement intéressé. "Et les profs? Ils acceptent que tu ne rendes pas toujours un travail parfait?"
                        
                        Tu souris: "En fait, la qualité de mon travail a augmenté depuis que je me concentre sur moins de choses à la fois. Et quand je dois faire un compromis, je suis transparent à ce sujet."
                        
                        En expliquant ton approche, tu réalises à quel point elle s\'est ancrée en toi. Ce n\'est plus juste une technique — c\'est devenu ta philosophie d\'étudiant.',
                        'stress_impact' => -1, 
                        'sleep_impact' => 1,
                        'grades_impact' => 1,
                        'stress_advice' => '"Enseigner est l\'une des meilleures façons d\'intégrer profondément un apprentissage."',
                        'sleep_advice' => '"Partager tes connaissances avec les autres renforce ta confiance et réduit l\'anxiété qui nuit au sommeil."',
                        'grades_advice' => '"Les meilleurs étudiants sont souvent ceux qui savent collaborer et partager leurs méthodes d\'apprentissage."',
                        'choices' => [
                            [
                                'text' => ' Continuer sur cette lancée équilibrée jusqu\'à la fin du semestre. ',
                                'next_chapter_number' => null
                            ],
                            [
                                'text' => 'Te laisser piéger par le perfectionnisme sur le projet final.',
                                'next_chapter_number' => 12
                            ]
                        ]
                    ],
                    
                    
                    
                    [
                        'chapter_number' => 15,
                        'content' => 'La période des examens finaux est terminée. Tu ranges tes affaires dans ton sac, quittant la salle de ton dernier test avec un sentiment de calme satisfaction.

                        En descendant les escaliers du bâtiment, tu croises des visages aux expressions diverses: certains étudiants semblent exténués, d\'autres euphoriques, beaucoup simplement soulagés. Tu réalises que ton propre visage n\'affiche ni l\'exaltation de celui qui a travaillé jusqu\'à l\'épuisement, ni la panique de celui qui a improvisé.
                        
                        Le semestre a été exigeant, comme tous les semestres en Ingénierie des Médias. Mais pour la première fois, tu l\'as traversé sans sacrifier ton bien-être. Tes notes sont solides — excellentes dans les matières qui te passionnent, correctes dans les autres.
                        
                        Plus important encore, tu te sens en forme pour attaquer la suite, qu\'il s\'agisse des stages professionnels ou du prochain semestre. Tu as acquis plus que des connaissances techniques; tu as développé une compétence que ni l\'IA ni l\'automatisation ne pourront remplacer: la capacité à gérer ton énergie mentale de façon durable.',
                        'stress_impact' => -1, 
                        'sleep_impact' => 1,
                        'grades_impact' => 1,
                        'stress_advice' => '"Le véritable succès académique n\'est pas de briller temporairement, mais de maintenir une flamme constante."',
                        'sleep_advice' => '"Les habitudes saines de sommeil que tu as développées te serviront bien au-delà de tes études."',
                        'grades_advice' => '"La vraie réussite n\'est pas seulement dans les notes, mais dans l\'équilibre que tu as su créer entre vie académique et personnelle."',
                        'choices' => [
                            [
                                'text' => 'Célébrer cette réussite avec tes amis et prendre un vrai temps de déconnexion avant la suite. ',
                                'next_chapter_number' => null
                            ],
                            [
                                'text' => ' Immédiatement te lancer dans un projet personnel intensif sans prendre de pause. ',
                                'next_chapter_number' => 13
                            ]
                        ]
                    ],

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
                    'stress_impact' => $chapterData['stress_impact'] ?? 0,
                    'sleep_impact' => $chapterData['sleep_impact'] ?? 0,
                    'grades_impact' => $chapterData['grades_impact'] ?? 0,
                    'stress_advice' => $chapterData['stress_advice'],
                    'sleep_advice' => $chapterData['sleep_advice'] ?? null,
                    'grades_advice' => $chapterData['grades_advice'] ?? null
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