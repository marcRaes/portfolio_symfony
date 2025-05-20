<?php


namespace App\DataFixtures\Faker;

use Faker\Provider\Base;

class TechProfileFakerProvider extends Base
{
    private array $usedSkills = [];
    private array $usedDevTools = [];
    private array $usedProjectName = [];
    private array $usedJobs = [];
    private array $usedCareerObjective = [];
    private array $usedAboutMe = [];
    private array $usedQuotes = [];

    public function getSkill(): string
    {
        $skills = [
            'PHP',
            'Java',
            'Python',
            'MySQL',
            'PostgreSQL',
            'MongoDB',
            'RabbitMQ',
            'C',
            'C++',
            'C#',
            'Go',
            'Javascript',
            'Swift',
            'HTML',
            'CSS',
            'Ruby',
            'Julia',
            'Scala',
            'Rust',
            'TypeScript',
            'Kotlin',
            'Bash',
            'Perl',
            'PowerShell',
            'SQL',
            'Objective-C',
            'R',
            'Haskell',
            'Lisp',
            'Prolog',
            'Assembleur',
            'Dart',
            'Groovy',
            'Scheme',
            'Fortran',
            'COBOL',
        ];

        return $this->uniqueElement($skills, $this->usedSkills);
    }

    public function getDevTool(): string
    {
        $devTools = [
            'Visual Studio Code',
            'Bitbucket',
            'Notion',
            'Laravel',
            'Symfony',
            'Spring',
            'Node.js',
            'React',
            'Vue.js',
            'Docker',
            'Kubernetes',
            'Git',
            'Github',
            'Gitlab',
            'Figma',
            'Ruby on rails',
            'Flutter',
            'Radmin',
            'Webstorm',
            'PhpStorm',
            'Jenkins',
            'Svelte',
            'GlassFlow',
            'Sublime Text',
            'Bootstrap',
            'Tailwind CSS',
            'Grunt',
            'SASS',
            'Postman',
            'NGINX',
            'Marvel',
            'Pico CSS',
            'MySQL Workbench',
            'Slack',
            'Trello',
            'Jira',
            'Webpack',
            'Composer',
            'Yarn',
            'NPM',
            'Xdebug',
            'Blackfire',
        ];

        return $this->uniqueElement($devTools, $this->usedDevTools);
    }

    public function getProjectName(): string
    {
        $projectName = [
            'Gestionnaire de projets',
            'Blog technique',
            'Portfolio personnel',
            'Application météo',
            'Dashboard analytique',
            'To-do list avancée',
            'Plateforme de e-learning',
            'Système de facturation',
            'Forum communautaire',
            'Système de gestion de tâches',
            'Application de réservation en ligne',
            'Plateforme de formation',
            'Outil de génération de devis',
            'CRM pour petites entreprises',
            'ERP modulaire open-source',
            'API d’authentification OAuth2',
            'Application de sondage en temps réel',
            'Solution de facturation SaaS',
            'Portail RH pour télétravail',
        ];

        return $this->uniqueElement($projectName, $this->usedProjectName);
    }

    public function getJob(): string
    {
        $jobs = [
            'Développeur back-end',
            'Développeur full-stack',
            'Ingénieur logiciel',
            'Lead développeur PHP',
            'Architecte logiciel',
            'Concepteur d’API',
            'Tech lead backend',
            'Développeur web sénior',
            'Consultant PHP/Symfony',
            'Développeur DevOps',
            'Développeur API REST',
            'Concepteur d’applications web',
        ];

        return $this->uniqueElement($jobs, $this->usedJobs);
    }

    public function getCareerObjective(): string
    {
        $careerObjective = [
            "<p>
                <strong>Mon ambition</strong> est de devenir un ingénieur logiciel capable de concevoir des architectures <em>robustes</em> et <em>évolutives</em>. 
                Je m’investis pleinement dans la qualité, la performance et la maintenabilité des systèmes.
            </p>",
            "<p>
                Je souhaite contribuer à des <strong>projets d’envergure</strong> en apportant une expertise technique solide et une forte capacité d’adaptation. 
                Mon objectif : <em>combiner innovation et excellence technique</em>.
            </p>",
            "<p>
                Passionné par l’ingénierie logicielle, je m’efforce d’<strong>améliorer en continu mes compétences</strong> 
                pour concevoir des solutions fiables et pérennes. Mon parcours s’inscrit dans une <em>logique de croissance continue</em>.
            </p>",
            "<p>
                Mon plan de carrière s’oriente vers des <strong>responsabilités techniques plus larges</strong>, 
                avec pour objectif de piloter des projets complexes et de garantir la <em>cohérence technique</em> des solutions mises en œuvre.
            </p>",
            "<p>
                En tant qu’ingénieur, je veux participer activement à la <strong>transformation numérique</strong> des entreprises en développant des outils 
                <em>performants</em> et adaptés aux enjeux actuels.
            </p>",
            "<p>
                Je construis mon parcours autour de la <strong>rigueur technique</strong>, de l’automatisation des processus et de l’<em>amélioration continue</em>. 
                Chaque ligne de code est une opportunité de faire mieux.
            </p>",
            "<p>
                Ma carrière est guidée par la volonté de créer des systèmes <strong>fiables, testables et maintenables</strong>. 
                J’accorde une grande importance à la <em>documentation, aux tests</em> et aux bonnes pratiques.
            </p>",
            "<p>
                Je vise à devenir un <strong>référent technique</strong> dans mon domaine, capable d’accompagner les équipes dans des choix d’architecture 
                et de favoriser la <em>montée en compétences collective</em>.
            </p>",
            "<p>
                Je suis motivé par les <strong>environnements complexes</strong> où l’ingénierie logicielle doit répondre à des enjeux de 
                <em>performance, de sécurité et de scalabilité</em>.
            </p>",
            "<p>
                Mon objectif est d’évoluer vers un rôle d’<strong>ingénieur principal</strong>, combinant excellence technique et 
                <em>mentorat</em> pour accompagner les équipes vers l’autonomie et la qualité.
            </p>",
            "<p>
                Je conçois mon avenir professionnel dans l’ingénierie comme un équilibre entre <strong>expertise technique</strong> et <em>impact métier</em>. 
                L’efficacité des outils que je développe est ma priorité.
            </p>",
            "<p>
                En tant qu’ingénieur passionné, je veux être un <strong>moteur d’innovation</strong> au sein des équipes. 
                Ma démarche est centrée sur l’<em>itération rapide</em>, les retours utilisateurs et l’amélioration continue.
            </p>",
            "<p>
                Mon plan de carrière s’inscrit dans une dynamique d’<strong>apprentissage constant</strong>, 
                avec l’objectif de rester à la pointe des technologies tout en produisant un <em>code propre et robuste</em>.
            </p>",
            "<p>
                Je veux faire évoluer mes compétences vers des <strong>rôles à forte responsabilité technique</strong>, 
                tout en gardant un lien étroit avec la production de code <em>de qualité</em>.
            </p>",
            "<p>
                <strong>Ce qui m’anime</strong> : résoudre des <em>problèmes complexes</em>, transmettre mon savoir, et contribuer à construire des systèmes techniques 
                <strong>élégants et durables</strong>.
            </p>",
        ];


        return $this->uniqueElement($careerObjective, $this->usedCareerObjective);
    }

    public function getAboutMe(): string
    {
        $aboutMe = [
            "<p>
                <strong>Ingénieur logiciel passionné</strong>, je conçois des solutions robustes en combinant rigueur technique et approche centrée utilisateur. 
                J’ai à cœur de livrer un code lisible, maintenable et bien testé. 
                <em>Chaque projet est une nouvelle opportunité de progresser et de créer de la valeur.</em>
            </p>",
            "<p>
                Développeur back-end spécialisé en <strong>PHP/Symfony</strong>, j’interviens sur toutes les phases d’un projet : architecture, développement, tests et déploiement.
                Je privilégie des solutions simples, évolutives et bien documentées. Mon objectif est d’assurer la fiabilité et la pérennité des systèmes que je construis.
            </p>",
            "<p>
                Curieux et autodidacte, j’accorde une attention particulière à l’<strong>automatisation, aux tests unitaires</strong> et à la qualité du code.
                Je crois en une tech responsable, au service des besoins réels. <em>Pour moi, chaque ligne de code doit avoir un but clair et mesurable.</em>
            </p>",
            "<p>
                Mon parcours est guidé par la volonté de <strong>concevoir des architectures performantes</strong> et de participer à des projets à fort impact.
                J’aime explorer de nouvelles technologies tout en consolidant mes bases. Je place la <em>collaboration et la clarté du code</em> au cœur de mon travail quotidien.
            </p>",
            "<p>
                Avec plusieurs années d’expérience en développement web, je maîtrise l’<strong>écosystème PHP moderne</strong> et les bonnes pratiques DevOps.
                Je m’implique dans des projets techniques exigeants, où la <em>résilience, la sécurité et la scalabilité</em> sont essentielles.
            </p>",
            "<p>
                Je suis convaincu que le métier de développeur ne se limite pas à coder. Il s’agit aussi de <strong>penser architecture, expérience utilisateur</strong> et performance métier.
                J’apporte une vision globale et structurée dans chacun des projets auxquels je participe.
            </p>",
            "<p>
                Mon objectif est d’évoluer vers un rôle de <strong>lead technique</strong>, tout en continuant à produire du code de qualité.
                J’apprécie particulièrement le <em>mentorat, les revues de code</em> et la transmission des bonnes pratiques au sein des équipes.
            </p>",
            "<p>
                Développeur orienté performance, je mets un point d’honneur à <strong>livrer du code optimisé</strong> dès le premier commit.
                J’adopte une démarche proactive pour anticiper les goulots d’étranglement et garantir la fluidité des applications.
            </p>",
            "<p>
                Mon approche se veut pragmatique : <strong>des solutions simples, testées et bien documentées</strong>.
                Je m’investis pleinement dans la phase de conception pour assurer la cohérence du produit final avec les enjeux métier.
            </p>",
            "<p>
                Formé aux pratiques agiles et aux principes SOLID, je conçois des applications web modernes dans un cadre structuré.
                Ma force réside dans ma capacité à <strong>adapter les solutions aux besoins évolutifs</strong> des utilisateurs tout en gardant un haut niveau de qualité technique.
            <p>",
            "<p>
                Je suis passionné par l’<strong>efficacité logicielle</strong> : tout ce qui peut être automatisé doit l’être.
                Cela me permet de concentrer mon énergie sur la valeur ajoutée réelle. <em>Le reste, c’est de l’optimisation continue.</em>
            <p>",
            "<p>
                Mon quotidien de développeur est animé par l’envie de <strong>résoudre des problèmes réels avec des solutions concrètes</strong>.
                Je crois que l’excellence technique commence par une bonne compréhension du besoin client et une architecture pensée dès le départ.
            <p>",
            "<p>
                Chaque projet est l’occasion de <strong>mettre en œuvre des technologies modernes</strong> tout en respectant les principes de simplicité et de lisibilité du code.
                Je veille à maintenir une base de code saine, propre, et bien structurée pour les équipes actuelles et futures.
            <p>",
            "<p>
                Développeur full-stack avec une sensibilité particulière pour le back-end, je m’efforce de <strong>travailler en synergie avec les équipes produit et design</strong>.
                Je m’implique aussi bien dans la réflexion que dans l’exécution, avec une attention constante aux performances et à la maintenabilité.
            <p>",
            "<p>
                <strong>Rigueur, curiosité et esprit d’équipe</strong> définissent ma manière de travailler.
                J’aime construire des systèmes utiles, performants et évolutifs, tout en apprenant chaque jour au contact de mes pairs et des défis techniques.
            <p>",
        ];

        return $this->uniqueElement($aboutMe, $this->usedAboutMe);
    }

    public function getQuote(): string
    {
        $quotes = [
            'Le code, c’est comme l’humour. S’il faut l’expliquer, c’est qu’il n’est pas bon.',
            'D’abord, résous le problème. Ensuite, écris le code.',
            'Les bons programmeurs se regardent les pieds en silence avant de coder.',
            'L’optimisation prématurée est la racine de tous les maux.',
            'Parler est bon marché. Montre-moi le code.',
            'Le logiciel, c’est dur. Mais c’est ce qui rend la chose amusante',
            'Tout bon codeur sait que moins de code, c’est souvent mieux.',
            'Les meilleurs programmeurs savent quand ne pas écrire de code.',
            'La simplicité, c’est la sophistication suprême.',
        ];

        return $this->uniqueElement($quotes, $this->usedQuotes);
    }

    private function uniqueElement(array &$pool, array &$used): string
    {
        $available = array_diff($pool, $used);
        if (empty($available)) {
            $used = [];
            $available = $pool;
        }
        $element = static::randomElement($available);
        $used[] = $element;

        return $element;
    }
}
