<?php

namespace App\Repository;

use App\Entity\Dinner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Dinner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dinner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dinner[]    findAll()
 * @method Dinner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DinnerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dinner::class);
    }

    public function findAllSortedByDate()
    {
        return $this->findBy([], ['day' => 'ASC']);
    }
}
