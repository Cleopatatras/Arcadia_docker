<?php

namespace App\Repository;

use App\Entity\Animaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animaux>
 */
class AnimauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animaux::class);
    }

    public function findDistinctRace(): array
    {
        $entityManager = $this->getEntityManager();

        // Requête pour récupérer les races uniques
        $query = $entityManager->createQuery(
            'SELECT DISTINCT a.race 
         FROM App\Entity\Animaux a
         ORDER BY a.race ASC'
        );

        return array_column($query->getResult(), 'race');
    }

    public function findDistinctNom(): array
    {
        $entityManager = $this->getEntityManager();

        // Requête pour récupérer les noms uniques
        $query = $entityManager->createQuery(
            'SELECT DISTINCT a.nom 
         FROM App\Entity\Animaux a
         ORDER BY a.nom ASC'
        );

        return array_column($query->getResult(), 'nom');
    }

    public function findByHabitatId(int $habitatId): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.habitat = :habitatId')
            ->setParameter('habitatId', $habitatId)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Animaux[] Returns an array of Animaux objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Animaux
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}