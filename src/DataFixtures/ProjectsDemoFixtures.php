<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker\TechProfileFakerProvider;
use App\Entity\DevTools;
use App\Entity\Projects;
use App\Entity\Skills;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

class ProjectsDemoFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Generator|TechProfileFakerProvider|FakerPicsumImagesProvider $faker */
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new TechProfileFakerProvider($faker));
        $faker->addProvider(new FakerPicsumImagesProvider($faker));
        $user = $this->getReference(UserDemoFixtures::DEMO_USER_REFERENCE, User::class);
        $skills = $manager->getRepository(Skills::class)->findBy(['user' => $user->getId(), 'display' => true]);
        $devTools = $manager->getRepository(DevTools::class)->findBy(['user' => $user->getId(), 'display' => true]);

        for ($nbProjects = 0; $nbProjects < $faker->numberBetween(4, 6); $nbProjects++) {
            $project = new Projects();
            $project->setName($faker->getProjectName());
            $project->setDescription($faker->realText(180, 2));
            $project->setUrl($faker->url);
            $project->setUrlGit($faker->url);
            $project->setPicture(basename($faker->image('public/uploads/project/demo', 300, 200)));
            $project->setUpdatedAt(new \DateTimeImmutable());

            for ($nbTech = 0; $nbTech < $faker->numberBetween(4, 8); $nbTech++) {
                $project->addSkill($skills[array_rand($skills)]);
                $project->addDevTool($devTools[array_rand($devTools)]);
            }

            $project->setDisplay($faker->boolean(80));
            $project->setUser($user);
            $project->setTraining($faker->boolean(70));

            $manager->persist($project);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserDemoFixtures::class,
            SkillsDemoFixtures::class,
            DevToolsDemoFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['demo'];
    }
}
