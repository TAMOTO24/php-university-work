<?php

namespace App\Controller;

use App\Entity\Trainers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trainers')]
class TrainersController extends AbstractController
{
    #[Route('/', name: 'trainers_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $trainers = $em->getRepository(Trainers::class)->findAll();
        return $this->json($trainers);
    }

    #[Route('/new', name: 'trainers_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $trainer = new Trainers();
        $trainer->setDescription($request->request->get('description'));
        $trainer->setFullName($request->request->get('fullName'));
        $trainer->setType($request->request->get('type'));

        $em->persist($trainer);
        $em->flush();

        return $this->json($trainer, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'trainers_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $trainer = $em->getRepository(Trainers::class)->find($id);

        if (!$trainer) {
            return $this->json(['error' => 'Trainer not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($trainer);
    }

    #[Route('/{id}/edit', name: 'trainers_edit', methods: ['POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $trainer = $em->getRepository(Trainers::class)->find($id);

        if (!$trainer) {
            return $this->json(['error' => 'Trainer not found'], Response::HTTP_NOT_FOUND);
        }

        $trainer->setDescription($request->request->get('description'));
        $trainer->setFullName($request->request->get('fullName'));
        $trainer->setType($request->request->get('type'));

        $em->flush();

        return $this->json($trainer);
    }

    #[Route('/{id}', name: 'trainers_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $trainer = $em->getRepository(Trainers::class)->find($id);

        if (!$trainer) {
            return $this->json(['error' => 'Trainer not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($trainer);
        $em->flush();

        return $this->json(['message' => 'Trainer deleted']);
    }
}
