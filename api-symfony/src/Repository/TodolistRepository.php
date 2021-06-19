<?php

namespace App\Repository;

use App\Entity\Todolist;
use App\Repository\TaskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Todolist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Todolist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Todolist[]    findAll()
 * @method Todolist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodolistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, TaskRepository $taskRepository)
    {
        parent::__construct($registry, Todolist::class);
        $this->taskRepository = $taskRepository;
    }

    public function transform(Todolist $todolist)
    {
        return [
            'id'    => (int) $todolist->getId(),
            'title' => (string) $todolist->getTitle(),
            'userid' => (string) $todolist->getUsertodo()->getId(),
            'useremail' => (string) $todolist->getUsertodo()->getUsername(),
            'tasks' => $this->taskRepository->transformAll($todolist)
        ];
    }

    public function transformAll()
    {
        $todolists = $this->findAll();
        $todolistsArray = [];
        foreach ($todolists as $todolist) {
            $todolistsArray[] = $this->transform($todolist);
        }
        return $todolistsArray;
    }

    // /**
    //  * @return Todolist[] Returns an array of Todolist objects
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
    public function findOneBySomeField($value): ?Todolist
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
