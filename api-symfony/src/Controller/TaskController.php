<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\TodolistRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{

    public function __construct(TaskRepository $taskRepository, TodolistRepository $todolistRepository, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->todolistRepository = $todolistRepository;
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Route("/api/task/create/{id}", name="task.createTask", methods="POST")
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

    /**
     * @Route("/api/task/update/{id}", name="task.updateTask", methods="PUT")
     */
    public function updateTask($id, Request $request): Response
    {
        $user = $this->userRepository->findUserByToken($request->headers->get('Authorization'));
        $task = $this->taskRepository->find($id);
        if($user !== $task->getTodolist()->getUsertodo()) {
            return $this->json([
                'error' => 'vous ne pouvez pas modifier cette tâche',
            ], 401);
        }
        $data = json_decode($request->getContent());
        if(isset($data->name))
            $task->setName($data->name);
        if(isset($data->isComplete))
            $task->setIsComplete($data->isComplete);
        $this->em->persist($task);
        $this->em->flush();
        return $this->json([
            'task' => $this->taskRepository->transform($task),
        ], 200, [], ['groups' => ['show']]);
    }

    /**
     * @Route("/api/task/delete/{id}", name="task.udeleteTask", methods="DELETE")
     */
    public function deleteTask($id, Request $request): Response
    {
        $user = $this->userRepository->findUserByToken($request->headers->get('Authorization'));
        $task = $this->taskRepository->find($id);
        if($user !== $task->getTodolist()->getUsertodo()) {
            return $this->json([
                'error' => 'vous ne pouvez pas supprimer cette tâche',
            ], 401);
        }
        $this->em->remove($task);
        $this->em->flush();
        return $this->json([
            'todolist' => "task delete",
        ]);
    }

}
