<?php

namespace App\Service\Image;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

readonly class DemoImageCleaner
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')] private string $projectDir,
        private Filesystem $filesystem,
    ) {}

    public function clean(string $directory): void
    {
        $pathDirectory = $this->projectDir . '/' . $directory;
        $finder = new Finder();

        foreach ($finder->in($pathDirectory)->files() as $file) {
            $this->filesystem->remove($file->getRealPath());
        }
    }

    public function directoryExists(string $pathDirectory): bool
    {
        return $this->filesystem->exists($pathDirectory);
    }
}
