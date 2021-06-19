<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\TodolistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{

    public function __construct(TaskRepository $taskRepository, TodolistRepository $todolistRepository, EntityManagerInterface $em)
    {
        $this->todolistRepository = $todolistRepository;
        $this->taskRepository = $taskRepository;
        $this->em = $em;
    }

    /**
     * @Route("/api/task/create/{id}", name="task.createTodolists", methods="POST")
     */
    public function createTask($id, Request $request): Response
    {
        $data = json_decode($request->getContent());
        $task = new Task();
        $task->setName($data->name);
        $task->setIsComplete(false);
        $task->setTodolist($this->todolistRepository->find($id));
        $this->em->persist($task);
        $this->em->flush();
        return $this->json([
            'task' => $this->taskRepository->transform($task),
        ], 200, [], ['groups' => ['show']]);
    }
}
