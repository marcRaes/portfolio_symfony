<?php

namespace App\Repository;

use App\Entity\DevTools;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DevTools>
 */
class DevToolsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DevTools::class);
    }

    public function findDisplay(User $user): array
    {
        return $this->createQueryBuilder('dt')
            ->andWhere('dt.display = 1')
            ->andWhere('dt.user = :user')
            ->setParameter('user', $user->getId())
            ->getQuery()
            ->getResult()
        ;
    }
}
