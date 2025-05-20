<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker\TechProfileFakerProvider;
use App\Entity\Quotes;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class QuotesDemoFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Generator|TechProfileFakerProvider $faker */
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new TechProfileFakerProvider($faker));

        for ($i = 0; $i < $faker->numberBetween(3, 7); $i++) {
            $quote = new Quotes();
            $quote->setContent($faker->getQuote());
            $quote->setAuthor($faker->name);
            $quote->setDisplay($faker->boolean(70));
            $quote->setUser($this->getReference(UserDemoFixtures::DEMO_USER_REFERENCE, User::class));

            $manager->persist($quote);
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
