<?php

namespace App\Service;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class Users extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUser()
    {
        return $this->createQueryBuilder('a')
        // ->andWhere('a.exampleField = :val')
        // ->setParameter('val', $value)
        ->orderBy('a.id', 'ASC')
        ->setMaxResults(1000)
        ->getQuery()
        ->getResult()
    ;
    }
}
