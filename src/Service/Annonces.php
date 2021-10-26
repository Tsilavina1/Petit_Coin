<?php

namespace App\Service;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Annonce;
use Doctrine\Persistence\ManagerRegistry;

class Annonces extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function getAnnonce()
    {
        return $this->createQueryBuilder('c')
            // ->andWhere('a.exampleField = :val')
            // ->setParameter('val', $value)
            ->orderBy('c.categorie', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }
}
