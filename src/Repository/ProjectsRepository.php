<?php

namespace App\Repository;

use App\Entity\Projects;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projects>
 */
class ProjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projects::class);
    }

    public function findDisplay(User $user): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.display = 1')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user->getId())
            ->addOrderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPerso(User $user): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.display = 1')
            ->andWhere('p.user = :user')
            ->andWhere('p.training = 1')
            ->setParameter('user', $user->getId())
            ->getQuery()
            ->getResult()
            ;
    }

    public function findPro(User $user): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.display = 1')
            ->andWhere('p.user = :user')
            ->andWhere('p.training = 0')
            ->setParameter('user', $user->getId())
            ->getQuery()
            ->getResult()
            ;
    }
}
