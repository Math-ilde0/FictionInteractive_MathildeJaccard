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
                'title' => 'Batterie Mentale - 🇫🇷',
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
                ],
                [
                    'title' => 'Mental Battery - 🇬🇧',
                    'summary' => 'This interactive story follows the journey of a Media Engineering student at HEIG-VD who navigates between projects, courses, and personal life. Each chapter presents a situation and possible choices that influence the protagonist\'s stress level, sleep, and grades.',
                    'chapters' => [
                        [
                            'chapter_number' => 1,
                            'content' => 'This Monday morning, your alarm screams at 6:30 am like a doomsday alert. Your eyes open with difficulty in your student room in Yverdon. You stare at the ceiling, overwhelmed by the mental list already unfolding: the web development project due Friday, the Data Visualization presentation this afternoon, and that programming exercise you haven\'t finished. HEIG-VD isn\'t known for being easy, but the Media Engineering program seems to have concentrated all its evaluations this week.
                            Your phone vibrates: a message from your project group already panicking at 6:30 in the morning. "Has anyone managed to deploy to the server?" You feel a knot forming in your stomach. The urge to go back to sleep is tempting, but the anxiety is there. You could skip breakfast and rush straight to your computer to get ahead, or take 15 minutes to eat properly and breathe before facing the day.',
                            'stress_advice' => '"The morning often sets the pace for your day. Taking a few minutes for yourself isn\'t wasted time."',
                            'sleep_advice' => '"A good breakfast helps your brain wake up, even after a difficult night."',
                            'grades_advice' => '"Starting the day calmly allows you to better organize your academic priorities."',
                            'choices' => [
                                [
                                    'text' => 'Get up, skip breakfast and go straight to your computer.',
                                    'next_chapter_number' => 2
                                ],
                                [
                                    'text' => 'Take 15 minutes for a real breakfast and breathing.',
                                    'next_chapter_number' => 3
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 2,
                            'content' => 'You arrive at HEIG a few minutes late, with your takeaway coffee half-spilled on your jacket. Room T102 is dimly lit, and the Data Visualization class has already started. You slip in discreetly at the back, while the professor projects complex graphs that you can\'t decode in your rush. Your stomach growls—coffee alone doesn\'t replace breakfast. Your computer boots up slowly while others are already immersed in the D3 practical exercise. Dozens of unread notifications appear: 36 messages in the D3 project group, 5 messages from professors, and a submission system alert: "Warning: you have 3 days left to submit your final project."',
                            'stress_impact' => 1,
                            'sleep_impact' => 0,
                            'grades_impact' => 0,
                            'is_recovery_point' => false,
                            'stress_advice' => "Constant rushing is the enemy of concentration. Sometimes, taking a step back allows you to take two steps forward.",
                            'sleep_advice' => "Skipping breakfast and consuming excess caffeine disturb your sleep cycle, even if you don't feel it immediately.",
                            'grades_advice' => "Arriving late makes you miss crucial information for understanding the material.",
                            'choices' => [
                                [
                                    'text' => 'Order a second coffee at the cafeteria and try to catch up with the class at all costs.',
                                    'next_chapter_number' => 4
                                ],
                                [
                                    'text' => 'Quietly step out to take a short break and clear your mind.',
                                    'next_chapter_number' => 5
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 3,
                            'content' => 'You\'ve taken time to breathe and refocus. Sitting on a bench on the HEIG-VD St-Roch campus, you observe the distant mountains. The fresh morning air fills your lungs, and you realize how precious this simple moment is. You take out your notebook and write down the real priorities for the day: first, finish the Media Production exercise (2 hours maximum), then dedicate the afternoon to the group project after the presentation. The stress doesn\'t completely disappear, but it becomes manageable. Your phone continues to vibrate, but you consciously decide not to check every notification. By mentally organizing your day, the tasks seem less overwhelming. "One thing at a time," you repeat to yourself.',
                            'stress_impact' => -1,
                            'sleep_impact' => 0,
                            'grades_impact' => 0,
                            'stress_advice' => '"Time management begins with consciously defining what deserves your immediate attention."',
                            'sleep_advice' => '"Regular breaks improve the quality of your sleep the following night."',
                            'grades_advice' => '"Knowing how to prioritize academic tasks is often more effective than trying to do everything at once."',
                            'choices' => [
                                [
                                    'text' => 'Open your planner and methodically organize your tasks for the week.',
                                    'next_chapter_number' => 5
                                ],
                                [
                                    'text' => 'Check Instagram "just for 5 minutes" to relax a bit more.',
                                    'next_chapter_number' => 6
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 4,
                            'content' => 'Your second coffee of the morning makes your heart beat at a worrying rate. Your hands shake slightly on your keyboard as you desperately try to catch up with the class. The Data Visualization professor is now talking about a JavaScript library you\'ve never heard of, and everyone around seems to understand perfectly. A Calendar notification appears: project meeting for the Value Proposition course in 45 minutes, and you haven\'t prepared your part. Your screen is split between the course you\'re trying to participate in and the increasingly anxious messages from your team. Your ability to concentrate is crumbling. Your throat tightens, and you feel like the classroom is shrinking around you.',
                            'stress_impact' => 2,
                            'sleep_impact' => -1,
                            'grades_impact' => -1,
                            'stress_advice' => '"Multitasking is a myth. Your brain cannot effectively focus on multiple complex tasks simultaneously."',
                            'sleep_advice' => '"Caffeine overload severely disrupts your sleep and can create a vicious cycle of fatigue and anxiety."',
                            'grades_advice' => '"Spreading your attention across multiple tasks guarantees that you won\'t do any of them properly."',
                            'choices' => [
                                [
                                    'text' => 'Ignore the class and work frantically on the project to meet deadlines.',
                                    'next_chapter_number' => 7
                                ],
                                [
                                    'text' => 'Close all applications except one and focus solely on the current class.',
                                    'next_chapter_number' => 5
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 5,
                            'content' => 'Now, you settle in the study space on the second floor, your computer open in front of you. Rather than reacting to each notification, you\'ve disabled alerts and opened a document with three columns: "Urgent," "Important," "Can wait." By categorizing your tasks, you realize that many things can wait until tomorrow. You identify the two critical actions for today: finalizing your Business Model Canvas for the group project and preparing key points for this afternoon\'s presentation. The simple act of having a clear plan lightens your mind. You start with the most complex task, giving yourself 90 minutes of total concentration. You put your phone in airplane mode and put on your headphones. For the first time today, your mind fully focuses on just one thing at a time.',
                            'stress_impact' => 0,
                            'sleep_impact' => 1,
                            'grades_impact' => -1,
                            'stress_advice' => '"Clarity of priorities is the first step toward serene productivity."',
                            'sleep_advice' => '"Organization reduces the nighttime anxiety that disrupts falling asleep."',
                            'grades_advice' => '"The quality of deep work on a single task always surpasses the quantity of superficial work on multiple tasks."',
                            'choices' => [
                                [
                                    'text' => 'Continue working methodically, with planned breaks.',
                                    'next_chapter_number' => 8
                                ],
                                [
                                    'text' => 'Agree to help another group that urgently asks for your assistance.',
                                    'next_chapter_number' => 6
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 6,
                            'content' => 'You end up scrolling on TikTok, and the "5 minutes" turn into 40. Travel videos, cooking, and ironically, productivity tips scroll by without you realizing it. When you become aware of the passing time, a wave of anxiety overwhelms you. You look at the time: 11:20. The project meeting is in 10 minutes, and you haven\'t prepared anything. You frantically open your Miro board, but your brain struggles to refocus. Three members of your project group have sent you personal messages, worried about your silence. Your phone rings: it\'s the project leader asking if everything is okay. You stammer an excuse, promising that everything will be ready. A feeling of impostor syndrome takes over. How could you waste so much time? You try to work on multiple files simultaneously, jumping from one task to another without really completing any of them.',
                            'stress_impact' => 3,
                            'sleep_impact' => -2,
                            'grades_impact' => -2,
                            'stress_advice' => '"Procrastination isn\'t a time management problem, but an emotional management problem when facing difficult tasks."',
                            'sleep_advice' => '"Anxiety accumulated during the day often manifests at night as insomnia or restless sleep."',
                            'grades_advice' => '"Social media is designed to capture your attention, exactly as they did today, at the expense of your academic work."',
                            'choices' => [
                                [
                                    'text' => 'Chain energy drinks to keep up the pace and work until very late.',
                                    'next_chapter_number' => 7
                                ],
                                [
                                    'text' => 'Admit your delay, apologize, and focus on a single priority task.',
                                    'next_chapter_number' => 8
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 7,
                            'content' => 'Your heart is racing. It\'s 4 PM, the day isn\'t over, but your body seems on the verge of collapse. In the HEIG computer lab, you stare at your screen where the lines of code are starting to blur before your tired eyes. You\'ve had three Red Bulls since this morning. Your hands are shaking on the keyboard. A migraine is settling behind your eyes, and you notice that you\'re clenching your jaw so tightly that your face hurts. Your presentation went poorly. You forgot key elements and stammered at the professor\'s questions. Your explanation of your algorithm was confusing, you know it. And now, the group project seems to be falling even further behind.',
                            'stress_impact' => 2,
                            'sleep_impact' => -3,
                            'grades_impact' => 0,
                            'stress_advice' => '"Your body sends you warning signals well before the breaking point. Learn to recognize them."',
                            'sleep_advice' => '"Caffeine and energy drinks cause a nervous system collapse after their temporary effect."',
                            'grades_advice' => '"An exhausted mind cannot produce quality work, which is reflected in your grades."',
                            'choices' => [
                                [
                                    'text' => 'Take a concentrated caffeine pill offered by a classmate to keep going until the end.',
                                    'next_chapter_number' => 9
                                ],
                                [
                                    'text' => 'Admit that you need air and go out for a ten-minute walk around campus.',
                                    'next_chapter_number' => 8
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 8,
                            'content' => 'You walk around the St-Roch center, the fresh Yverdon wind on your face. For the first time today, you take a real deep breath, filling your lungs with fresh air. The lake shines in the distance. You sit on a bench and close your eyes for a moment, practicing a breathing technique that your friend showed you. Four seconds inhale, hold for four seconds, exhale for six seconds. After a few cycles, your mind clears enough to realize the obvious: you can\'t do everything perfectly. No one can. You make a decision: rather than doing everything mediocrely, you\'ll choose what\'s truly essential and do it properly. You send an honest message to your group: "I\'ve fallen behind, focusing on the main functionality for tonight. Improvements will come tomorrow."',
                            'stress_impact' => -2,
                            'sleep_impact' => 2,
                            'grades_impact' => 1,
                            'stress_advice' => '"Honesty with yourself and others is liberating. No one is superhuman."',
                            'sleep_advice' => '"Light physical exercise like walking helps regulate the stress hormones that disrupt sleep."',
                            'grades_advice' => '"Knowing how to recognize your limits and communicate honestly is a professional skill valued by teachers."',
                            'choices' => [
                                [
                                    'text' => 'Return inside with a clear plan for the evening and the rest of the week.',
                                    'next_chapter_number' => 9
                                ],
                                [
                                    'text' => 'Let yourself be convinced by a classmate to join a late-night coding session to catch up on everything at once.',
                                    'next_chapter_number' => 10
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 9,
                            'content' => 'You settle in the library with a new mindset. Your computer is open, but this time, only one application is running: Visual Studio Code, focused on the main task. Your plan is simple: two hours of targeted work on the backend API that your group is waiting for. No social media, no emails, just code. You\'ve even set a timer: 25 minutes of work, 5 minutes of break. The first lines are difficult, but gradually, the flow sets in. The functions chain together, the tests turn green. During your break, you stretch and look out the window, rather than checking your phone. You feel a deep satisfaction, different from the feverish agitation of this morning. It\'s not euphoria, but rather a productive tranquility, as if you\'ve found your natural rhythm.',
                            'stress_impact' => -1,
                            'sleep_impact' => 0,
                            'grades_impact' => 0,
                            'stress_advice' => '"The true state of flow comes from a balance between challenge and skill, not from excessive pressure."',
                            'sleep_advice' => '"Satisfying and well-framed work during the day promotes deep and restorative sleep at night."',
                            'grades_advice' => '"The Pomodoro technique (25 min of work, 5 min of break) is scientifically proven to improve the quality and retention of academic work."',
                            'choices' => [
                                [
                                    'text' => 'Send your work to the group and decide to go home at a reasonable hour tonight.',
                                    'next_chapter_number' => 11
                                ],
                                [
                                    'text' => 'Take advantage of this momentum to add a dozen bonus features you had envisioned.',
                                    'next_chapter_number' => 10
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 10,
                            'content' => 'You\'ve managed to maintain your balanced rhythm for two days. The members of your Value Proposition group notice the change: your contributions are more focused, and you communicate more clearly. At the end of the Value Proposition course, your professor holds you back: "Your group is progressing well on the main project. I have an opportunity for you — a hackathon at RTS this weekend. It\'s a chance to get noticed." Part of you is excited by the idea. It\'s exactly the kind of opportunity that could enrich your CV. But another part of you remembers the state you were in two days ago and wonders if it\'s reasonable to add this to your workload. You look at your schedule for the week: there are still two projects to finalize, and you\'re just starting to regain a normal sleep rhythm.',
                            'stress_impact' => 0,
                            'sleep_impact' => 0,
                            'grades_impact' => 0,
                            'stress_advice' => '"Opportunities are infinite, but your energy and time are not. Choosing also means giving up."',
                            'sleep_advice' => '"Sometimes, saying no today allows you to say yes to better opportunities tomorrow, with more energy."',
                            'grades_advice' => '"Professors respect students who know their limits and can manage their workload."',
                            'choices' => [
                                [
                                    'text' => 'Politely decline the hackathon invitation, explaining that you need to manage your current workload.',
                                    'next_chapter_number' => 11
                                ],
                                [
                                    'text' => 'Accept the hackathon enthusiastically — you\'ll sleep next week!',
                                    'next_chapter_number' => 12
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 11,
                            'content' => '"I really appreciate this opportunity, Professor, but I must decline. I\'m committed to delivering quality work on my current projects, and I need to respect my limits." The words come out of your mouth with an assurance that surprises even yourself. The professor looks at you for a moment, then nods with what looks like respect. "That\'s a mature decision. The hackathon will come back, don\'t worry." As you leave the building, you feel a strange mix of relief and slight disappointment. Did you miss an opportunity? Maybe. But walking toward your apartment, you realize that you\'ve just done something important: established a healthy boundary. Tonight, you have time to prepare a real meal instead of eating a sandwich in front of your computer. You even take an hour to call your parents, who are surprised to hear you so relaxed during project season.',
                            'stress_impact' => 1,
                            'sleep_impact' => 0,
                            'grades_impact' => 0,
                            'stress_advice' => '"Saying no to certain things allows you to say a more committed yes to others."',
                            'sleep_advice' => '"A relaxed evening without screens before bedtime significantly improves the quality of sleep."',
                            'grades_advice' => '"Consistency in the quality of work is better than peaks of excellence followed by exhaustion."',
                            'choices' => [
                                [
                                    'text' => 'Maintain this course and give as much importance to your well-being as to your studies.',
                                    'next_chapter_number' => 13
                                ],
                                [
                                    'text' => 'Compensate for your refusal by redoubling your efforts on your current projects to prove your worth.',
                                    'next_chapter_number' => 12
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 12,
                            'content' => 'Days pass and your schedule is overflowing. Between classes at HEIG, the hackathon you accepted, and your main project, every minute is counted. You barely sleep 5 hours a night, and your diet consists of snacks eaten on the go. Your performance remains correct, but you notice that your mind is no longer as sharp. During a group presentation in UX, you lose track of your ideas several times. A classmate has to step in to finish your explanation. In the corridors, you pass a third-year student who says: "Are you okay? You look terrible." You brush off the remark, but looking at yourself in the bathroom mirror, you don\'t recognize the exhausted face staring back at you. Tonight, the web development professor has proposed an optional advanced revision session. You hesitate — your body is begging you to go home and sleep, but you\'re afraid of falling behind.',
                            'stress_impact' => 2,
                            'sleep_impact' => -3,
                            'grades_impact' => 0,
                            'stress_advice' => '"Sustained excellence requires periods of recovery. Even elite athletes schedule rest days."',
                            'sleep_advice' => '"Research shows that after 16 hours of being awake, your cognitive abilities are equivalent to those of a legally drunk person."',
                            'grades_advice' => '"Long-term memory, essential for exams, consolidates during the deep sleep that you\'re not getting right now."',
                            'choices' => [
                                [
                                    'text' => 'Ignore all warning signs and attend the extra session.',
                                    'next_chapter_number' => null
                                ],
                                [
                                    'text' => 'Listen to your body and go home to rest, even if it means missing an opportunity.',
                                    'next_chapter_number' => 13
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 13,
                            'content' => 'It\'s Friday afternoon, the week is coming to an end. You\'re sitting in the park next to HEIG, reviewing notes from the last project meeting. The sun filters through the tree leaves, projecting changing patterns on your notebook. These past few days, you\'ve maintained an amazing discipline: 7 hours of sleep per night, meals taken away from your computer, and most importantly, clear boundaries between work and rest. You\'ve even started running again in the morning, just 20 minutes, but enough to clear your mind. Your class notes are more organized, your contributions to the project more relevant. The amount of work hasn\'t decreased, but your approach to it has changed. You no longer react in constant urgency. A classmate walks by and stops: "How do you stay so calm with all these deadlines? Do you have a secret?"',
                            'stress_impact' => -2,
                            'sleep_impact' => 2,
                            'grades_impact' => 2,
                            'stress_advice' => '"The real secret of productivity isn\'t doing more, but recovering better."',
                            'sleep_advice' => '"Morning exercise regulates sleep hormones and improves the quality of your nighttime rest."',
                            'grades_advice' => '"Regularity in effort is the key to sustainable academic success."',
                            'choices' => [
                                [
                                    'text' => 'Share your stress management and organization techniques with them.',
                                    'next_chapter_number' => 14
                                ],
                                [
                                    'text' => 'Minimize your progress and immediately get back to work for fear of relaxing too much.',
                                    'next_chapter_number' => 12
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 14,
                            'content' => '"Actually, I\'ve just learned to respect my limits," you explain to your classmate. You sit on a bench and show them your simple system: a planner where each task is deliberately scheduled with buffer time, recovery periods clearly marked in green, and a daily priority list limited to three items maximum. "The trick is that I no longer try to be perfect in everything. I\'ve chosen the areas where I really want to excel, and for the rest, I just aim for correct competence." Your classmate takes notes, visibly interested. "And the professors? They accept that you don\'t always turn in perfect work?" You smile: "Actually, the quality of my work has increased since I focus on fewer things at a time. And when I have to compromise, I\'m transparent about it." As you explain your approach, you realize how deeply it has become anchored in you. It\'s no longer just a technique — it\'s become your student philosophy.',
                            'stress_impact' => -1,
                            'sleep_impact' => 1,
                            'grades_impact' => 1,
                            'stress_advice' => '"Teaching is one of the best ways to deeply integrate learning."',
                            'sleep_advice' => '"Sharing your knowledge with others strengthens your confidence and reduces anxiety that harms sleep."',
                            'grades_advice' => '"The best students are often those who know how to collaborate and share their learning methods."',
                            'choices' => [
                                [
                                    'text' => 'Continue on this balanced path until the end of the semester.',
                                    'next_chapter_number' => null
                                ],
                                [
                                    'text' => 'Let yourself be trapped by perfectionism on the final project.',
                                    'next_chapter_number' => 12
                                ]
                            ]
                        ],
                        [
                            'chapter_number' => 15,
                            'content' => 'The final exam period is over. You pack your things into your bag, leaving the room of your last test with a feeling of calm satisfaction. Walking down the building stairs, you pass faces with various expressions: some students look exhausted, others euphoric, many simply relieved. You realize that your own face displays neither the exaltation of someone who has worked to exhaustion, nor the panic of someone who has improvised. The semester has been demanding, like all semesters in Media Engineering. But for the first time, you\'ve gone through it without sacrificing your well-being. Your grades are solid — excellent in the subjects that passion you, correct in others. More importantly, you feel fit to tackle what\'s next, whether it\'s professional internships or the next semester. You\'ve acquired more than technical knowledge; you\'ve developed a skill that neither AI nor automation will be able to replace: the ability to sustainably manage your mental energy.',
                            'stress_impact' => -1,
                            'sleep_impact' => 1,
                            'grades_impact' => 1,
                            'stress_advice' => '"True academic success is not about shining temporarily, but maintaining a constant flame."',
                            'sleep_advice' => '"The healthy sleep habits you\'ve developed will serve you well beyond your studies."',
                            'grades_advice' => '"Real success isn\'t just in your grades, but in the balance you\'ve created between academic and personal life."',
                            'choices' => [
                                [
                                    'text' => 'Celebrate this success with your friends and take a real time to disconnect before moving on.',
                                    'next_chapter_number' => null
                                ],
                                [
                                    'text' => 'Immediately launch into an intensive personal project without taking a break.',
                                    'next_chapter_number' => 13
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