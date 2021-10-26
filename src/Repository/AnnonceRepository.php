<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    /**
     * @return Annonce[] Returns an array of Annonce objects
     */

    public function findByExampleField()
    {
        return $this->createQueryBuilder('a')
            // ->andWhere('a.exampleField = :val')
            // ->setParameter('val', $value)
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findMyAnnouncebyCategory(int $idcategorie): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM annonce
            WHERE categorie_id=:idcategorie
            ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['idcategorie' => $idcategorie]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }

    public function sortAnnounceBy($query)
    {
        return $this->createQueryBuilder('req')
            ->orderBy('req.id', 'DESC')
            ->where($query)
            ->getQuery()
            ->getResult();
    }
}
