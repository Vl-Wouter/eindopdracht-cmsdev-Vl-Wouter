<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * Find all tasks and order them by status
     * @return mixed
     */
    public function findAndOrderByStatus() {
        return $this->createQueryBuilder( 't')
            ->orderBy('t.status', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Return all tasks with a certain client
     * @param $id
     * @return mixed
     */
    public function findByClient($id) {
        return $this->createQueryBuilder('t')
            ->where('t.client = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    /**
     * Return all tasks with a certain employee
     * @param $id
     * @return mixed
     */
    public function findByEmployee($id) {
        return $this->createQueryBuilder('t')
            ->where('t.employee = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
