<?php

namespace App\Repository;

use App\Entity\Ecole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ecole>
 *
 * @method Ecole|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ecole|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ecole[]    findAll()
 * @method Ecole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EcoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ecole::class);
    }

    public function add(Ecole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ecole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * Recherche une école par son nom.
     *
     * @param string $nom Le nom de l'école à rechercher.
     *
     * @return Ecole|null L'école correspondante ou null si non trouvée.
     */
    public function findByNom(string $nom): ?Ecole
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.Nom = :nom')
            ->setParameter('nom', $nom)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Ecole[] Returns an array of Ecole objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ecole
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
