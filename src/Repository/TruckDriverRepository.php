<?php

namespace App\Repository;

use App\Entity\TruckDriver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TruckDriver>
 *
 * @method TruckDriver|null find($id, $lockMode = null, $lockVersion = null)
 * @method TruckDriver|null findOneBy(array $criteria, array $orderBy = null)
 * @method TruckDriver[]    findAll()
 * @method TruckDriver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TruckDriverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TruckDriver::class);
    }

    public function add(TruckDriver $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TruckDriver $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


}
