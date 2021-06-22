<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Todolist;
use App\Repository\UserRepository;
use App\Repository\TodolistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TodolistController extends AbstractController
{

    public function __construct(TodolistRepository $todolistRepository, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->todolistRepository = $todolistRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Route("/api/todolists", name="todolist.getTodolists", methods="GET")
     */
    public function getTodolists(Request $request): Response
    {
        $filterUser = $request->query->get('filterUser');
        $filterIsComplete = $request->query->get('filterIsComplete');
        return $this->json([
            'todolists' => $this->todolistRepository->transformAll($filterUser, $filterIsComplete),
        ]);
    }

    /**
     * @Route("/api/todolist/create", name="todolist.createTodolists", methods="POST")
     */
    public function createTodolist(Request $request): Response
    {
        $user = $this->userRepository->findUserByToken($request->headers->get('Authorization'));
        $data = json_decode($request->getContent());
        $todolist = new Todolist();
        $todolist->setTitle($data->title);
        $todolist->setUsertodo($user);
        $this->em->persist($todolist);
        $this->em->flush();
        for($i = 0; $i < count($data->tasks); $i++) {
            $task = new Task();
            $task->setName($data->tasks[$i]->name);
            $task->setIsComplete(false);
            $task->setTodolist($this->todolistRepository->find($todolist->getId()));
            $this->em->persist($task);
            $this->em->flush();
        }
        return $this->json([
            'todolist' => $this->todolistRepository->transform($todolist),
        ], 200, [], ['groups' => ['show']]);
    }

    /**
     * @Route("/api/todolist/update/{id}", name="todolist.updateTodolists", methods="PUT")
     */
    public function updateTodolist($id, Request $request): Response
    {
        $user = $this->userRepository->findUserByToken($request->headers->get('Authorization'));
        $todolist = $this->todolistRepository->find($id);
        if($user !== $todolist->getUsertodo()) {
            return $this->json([
                'error' => 'vous ne pouvez pas changer cette todolist',
            ], 401);
        }   
        $data = json_decode($request->getContent());
        $todolist->setTitle($data->title);
        $this->em->persist($todolist);
        $this->em->flush();
        return $this->json([
            'todolist' => $this->todolistRepository->transform($todolist),
        ], 200, [], ['groups' => ['show']]);
    }

    /**
     * @Route("/api/todolist/delete/{id}", name="todolist.deleteTodolists", methods="DELETE")
     */
    public function deleteTodolist($id,  Request $request): Response
    {
        $user = $this->userRepository->findUserByToken($request->headers->get('Authorization'));
        $todolist = $this->todolistRepository->find($id);
        if($user !== $todolist->getUsertodo()) {
            return $this->json([
                'error' => 'vous ne pouvez pas supprimer cette todolist',
            ], 401);
        }   
        $this->em->remove($todolist);
        $this->em->flush();
        return $this->json([
            'todolist' => "todolist delete",
        ], 200);
    }

}
