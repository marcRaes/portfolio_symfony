<?php

namespace App\Repository;

use App\Entity\Skills;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Skills>
 */
class SkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skills::class);
    }

    public function findDisplay(User $user): array
    {
        return $this->createQueryBuilder('s')
            ->select('s.name')
            ->andWhere('s.display = 1')
            ->andWhere('s.user = :user')
            ->setParameter('user', $user->getId())
            ->getQuery()
            ->getResult()
        ;
    }
}
