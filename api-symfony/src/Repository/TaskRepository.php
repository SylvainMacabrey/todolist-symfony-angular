<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\Todolist;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function transform(Task $task)
    {
        return [
            'id'    => (int) $task->getId(),
            'name' => (string) $task->getName(),
            'isComplete' => (boolean) $task->getIsComplete()
        ];
    }

    public function transformAll(Todolist $todolist, $filterIsComplete)
    {
        $qb = $this->createQueryBuilder('task')
                   ->where('task.todolist = :todolist')->setParameter('todolist', $todolist);
        if(isset($filterIsComplete)) {
            $qb->andWhere('task.isComplete = :filter')->setParameter('filter', $filterIsComplete);
        }
        $tasks = $qb->getQuery()->execute();
        //$tasks = $todolist->getTasks();
        $tasksArray = [];
        foreach ($tasks as $task) {
            $tasksArray[] = $this->transform($task);
        }
        return $tasksArray;
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
