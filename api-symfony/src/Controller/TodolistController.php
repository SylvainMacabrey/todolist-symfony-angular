<?php

namespace App\Controller;

use App\Repository\TodolistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TodolistController extends AbstractController
{

    public function __construct(TodolistRepository $todolistRepository, EntityManagerInterface $em)
    {
        $this->todolistRepository = $todolistRepository;
        $this->em = $em;
    }

    /**
     * @Route("/api/todolists", name="todolist.getTodolists")
     */
    public function getTodolists(): Response
    {
        return $this->json([
            'todolists' => $this->todolistRepository->transformAll(),
        ]);
    }
}
