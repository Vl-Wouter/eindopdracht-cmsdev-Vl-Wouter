<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

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
            ->orderBy('t.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAndGroupByDay() {
        return $this->createQueryBuilder('t')
            ->select('count(t.id) as tasks, t.date')
            ->where('t.date < :now')
            ->setParameter('now', new \DateTime())
            ->groupBy('t.date')
            ->orderBy('t.date', 'ASC')
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
            ->where('t.period = :id')
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
            ->orderBy('t.date', "DESC")
            ->getQuery()
            ->getResult();
    }

    public function findPeriod($start, $end) {
        return $this->createQueryBuilder('t')
            ->select('count(t.id) as task_total, sum(t.price) as task_price')
            ->where('t.date BETWEEN :start and :end')
            ->andWhere('t.status = 1')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }

    public function findTopEmployee() {
        return $this->createQueryBuilder('t')
            ->select('u.first_name, u.last_name, u.roles, sum(t.price) as total_price')
            ->innerJoin(User::class, 'u', Join::WITH, 'u.id = t.employee')
            ->groupBy('t.employee')
            ->orderBy('total_price', 'DESC')
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
