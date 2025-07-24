<?php

namespace App\Repository;

use App\Entity\Entrainement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entrainement>
 *
 * @method Entrainement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrainement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrainement[]    findAll()
 * @method Entrainement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrainementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrainement::class);
    }

    /**
     * Find training sessions by user
     */
    public function findByUser(int $userId): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.utilisateur = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('e.dateEntrainement', 'DESC')
            ->getQuery()
            ->getResult();
    }
}