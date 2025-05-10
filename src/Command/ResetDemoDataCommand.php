<?php

namespace App\Command;

use App\Entity\Quotes;
use App\Entity\User;
use App\Entity\Projects;
use App\Entity\Skills;
use App\Entity\DevTools;
use App\Service\Image\DemoImageCleaner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'app:reset-demo-data',
    description: 'Réinitialise les données de démonstration',
)]
class ResetDemoDataCommand extends Command
{
    private const string PICTURES_DIRECTORY_DEMO = 'public/uploads/project/demo';

    private array $entityLabels = [
        Projects::class => 'projets',
        Skills::class => 'compétences',
        DevTools::class => 'outils',
        Quotes::class => 'citations',
    ];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        #[Autowire('%env(APP_DEMO_EMAIL)%')] private readonly string $demoEmail,
        private readonly DemoImageCleaner $demoImageCleaner,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$this->demoEmail) {
            $io->error('APP_DEMO_EMAIL non défini dans le .env');

            return Command::FAILURE;
        }

        if (!$this->demoImageCleaner->directoryExists(self::PICTURES_DIRECTORY_DEMO)) {
            $io->error('Répertoire images du mode démo inexistant.');

            return Command::FAILURE;
        }

        $demoUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $this->demoEmail]);

        $io->title('Réinitialisation des données de démonstration');

        foreach ([Projects::class, Skills::class, DevTools::class, Quotes::class] as $entityClass) {
            $label = $this->entityLabels[$entityClass];
            $items = $this->entityManager->getRepository($entityClass)->findBy(['user' => $demoUser]);
            $count = 0;

            $io->section('Suppression des ' . $label . ' en cours...');

            foreach ($items as $item) {
                $this->entityManager->remove($item);
                $count++;
            }

            $io->success($count . ' ' . $label . ' supprimé(s).' );
        }

        if ($demoUser) {
            $this->entityManager->remove($demoUser);
            $this->entityManager->flush();
            $io->success('Utilisateur démo supprimé.');
        }

        $this->demoImageCleaner->clean(self::PICTURES_DIRECTORY_DEMO);

        $io->success('Répertoire images du mode démo vidé.' );
        $io->info('Génération des nouvelle fixtures' );

        $process = new Process(['php', 'bin/console', 'doctrine:fixtures:load', '--group=demo', '--append', '--no-interaction']);
        $process->run(fn ($type, $buffer) => $io->write($buffer));

        if (!$process->isSuccessful()) {
            $io->error('Erreur lors du chargement des fixtures.');

            return Command::FAILURE;
        }

        $io->success('Les données de démonstration ont été réinitialisées avec succès.');


        return Command::SUCCESS;
    }
}
