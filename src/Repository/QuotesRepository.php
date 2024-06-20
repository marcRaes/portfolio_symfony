<?php

namespace App\Repository;

use App\Entity\Quotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quotes>
 */
class QuotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quotes::class);
    }

    public function findDisplay(): array
    {
        $quotes = $this->createQueryBuilder('p')
            ->andWhere('p.display = 1')
            ->getQuery()
            ->getResult()
        ;
        shuffle($quotes);

        return $quotes;
    }
}
