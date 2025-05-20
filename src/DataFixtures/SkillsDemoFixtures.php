<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker\TechProfileFakerProvider;
use App\Entity\Skills;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class SkillsDemoFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Generator|TechProfileFakerProvider $faker */
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new TechProfileFakerProvider($faker));

        for ($i = 0; $i < $faker->numberBetween(10, 20); $i++) {
            $skill = new Skills();
            $skill->setName($faker->getSkill());
            $skill->setPercentage(1);
            $skill->setDisplay($faker->boolean(80));
            $skill->setUser($this->getReference(UserDemoFixtures::DEMO_USER_REFERENCE, User::class));

            $manager->persist($skill);
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
