<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker\TechProfileFakerProvider;
use App\Entity\DevTools;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class DevToolsDemoFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Generator|TechProfileFakerProvider $faker */
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new TechProfileFakerProvider($faker));

        for ($i = 0; $i < $faker->numberBetween(10, 20); $i++) {
            $tool = new DevTools();
            $tool->setName($faker->getDevTool());
            $tool->setDisplay($faker->boolean(80));
            $tool->setUser($this->getReference(UserDemoFixtures::DEMO_USER_REFERENCE, User::class));

            $manager->persist($tool);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserDemoFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['demo'];
    }
}
