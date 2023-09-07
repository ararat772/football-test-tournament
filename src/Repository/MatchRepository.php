<?php

namespace App\Repository;

use App\Entity\Matchh;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matchh>
 *
 * @method Matchh|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matchh|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matchh[]    findAll()
 * @method Matchh[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matchh::class);
    }
}
