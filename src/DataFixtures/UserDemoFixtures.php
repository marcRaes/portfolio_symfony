<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker\TechProfileFakerProvider;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDemoFixtures extends Fixture implements FixtureGroupInterface
{
    public const string DEMO_USER_REFERENCE = 'demo-user';

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        #[Autowire('%env(APP_DEMO_EMAIL)%')] private readonly string $demoEmail,
        #[Autowire('%env(APP_DEMO_PASSWORD)%')] private readonly string $demoPassword,
        #[Autowire('%env(APP_DEMO_ROLE)%')] private readonly string $demoRole,
    ) {}

    /**
     * @throws NumberParseException
     */
    public function load(ObjectManager $manager): void
    {
        /** @var Generator|TechProfileFakerProvider $faker */
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new TechProfileFakerProvider($faker));
        $phoneUtil = PhoneNumberUtil::getInstance();
        $mobileNumber = $faker->randomElement(['06', '07']) . $faker->numerify('########');
        $parsedPhone = $phoneUtil->parse($mobileNumber, 'FR');

        $user = new User();
        $user->setName($faker->lastName());
        $user->setFirstName($faker->firstName());
        $user->setEmail($this->demoEmail);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $this->demoPassword));
        $user->setPhone($parsedPhone);
        $user->setDateOfBirth($faker->dateTimeBetween('-40 years', '-20 years'));
        $user->setAddress($faker->address());
        $user->setJob($faker->getJob());
        $user->setCareerObjective($faker->getCareerObjective());
        $user->setAboutMe($faker->getAboutMe());
        $user->setUrlLinkedin($faker->url());
        $user->setRoles(explode(', ', $this->demoRole));
        $user->setIsVerified(true);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::DEMO_USER_REFERENCE, $user);
    }

    public static function getGroups(): array
    {
        return ['demo'];
    }
}
