<?php

namespace App\Repository;

use App\Entity\Auto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auto>
 *
 * @method Auto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auto[]    findAll()
 * @method Auto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auto::class);
    }

    /**
     * @return Auto[] Returns an array of Auto objects that are not soft deleted
     */
    public function findNotDeleted(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }

    // Megjegyzés: A többi kikommentezett metódust hagyhatod kikommentezve, 
    // vagy törölheted, ha nem használod őket.
}
// Ez az új metódus segítségével a "soft delete"-elve autókat kihagyva fogja visszaadni az összes autót az adatbázisból. Azokat az autókat fogja listázni, amelyeknél a deletedAt értéke NULL.

// Miután hozzáadtad ezt a metódust az AutoRepository osztályhoz, már használhatod is a AutoController-ben, ahogy korábban is írtam.






//    /**
//     * @return Auto[] Returns an array of Auto objects
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

//    public function findOneBySomeField($value): ?Auto
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

