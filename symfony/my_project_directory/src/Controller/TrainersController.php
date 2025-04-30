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
        return $this->render('trainers/index.html.twig', [
            'trainers' => $trainers,
        ]);
    }

    #[Route('/new', name: 'trainers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $trainer = new Trainers();
            $trainer->setDescription($request->request->get('description'));
            $trainer->setFullName($request->request->get('fullName'));
            $trainer->setType($request->request->get('type'));

            $em->persist($trainer);
            $em->flush();

            return $this->redirectToRoute('trainers_index');
        }

        return $this->render('trainers/new.html.twig');
    }

    #[Route('/{id}', name: 'trainers_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $trainer = $em->getRepository(Trainers::class)->find($id);

        if (!$trainer) {
            return $this->json(['error' => 'Trainer not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->render('trainers/show.html.twig', [
            'trainer' => $trainer,
        ]);
    }

    #[Route('/{id}/edit', name: 'trainers_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $trainer = $em->getRepository(Trainers::class)->find($id);

        if (!$trainer) {
            return $this->json(['error' => 'Trainer not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->isMethod('POST')) {
            $trainer->setDescription($request->request->get('description'));
            $trainer->setFullName($request->request->get('fullName'));
            $trainer->setType($request->request->get('type'));

            $em->flush();

            return $this->redirectToRoute('trainers_index');
        }

        return $this->render('trainers/edit.html.twig', [
            'trainer' => $trainer,
        ]);
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

        return $this->redirectToRoute('trainers_index');
    }
}

