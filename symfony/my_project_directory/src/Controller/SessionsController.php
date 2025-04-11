<?php

namespace App\Controller;

use App\Entity\Sessions;
use App\Entity\Exercises;
use App\Entity\ClubMembers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sessions')]
class SessionsController extends AbstractController
{
    #[Route('/', name: 'sessions_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $sessions = $em->getRepository(Sessions::class)->findAll();
        return $this->json($sessions);
    }

    #[Route('/new', name: 'sessions_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $exercise = $em->getRepository(Exercises::class)->find($request->request->get('exercise_id'));
        $trainer = $em->getRepository(ClubMembers::class)->find($request->request->get('trainer_id'));

        if (!$exercise || !$trainer) {
            return $this->json(['error' => 'Exercise or Trainer not found'], Response::HTTP_BAD_REQUEST);
        }

        $session = new Sessions();
        $session->setExercise($exercise);
        $session->setTrainer($trainer);
        $session->setDateTime(new \DateTime($request->request->get('date_time')));
        $session->setLocation($request->request->get('location'));

        $em->persist($session);
        $em->flush();

        return $this->json($session, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'sessions_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $session = $em->getRepository(Sessions::class)->find($id);

        if (!$session) {
            return $this->json(['error' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($session);
    }

    #[Route('/{id}/edit', name: 'sessions_edit', methods: ['POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $session = $em->getRepository(Sessions::class)->find($id);

        if (!$session) {
            return $this->json(['error' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        $exercise = $em->getRepository(Exercises::class)->find($request->request->get('exercise_id'));
        $trainer = $em->getRepository(ClubMembers::class)->find($request->request->get('trainer_id'));

        if ($exercise) {
            $session->setExercise($exercise);
        }

        if ($trainer) {
            $session->setTrainer($trainer);
        }

        $session->setDateTime(new \DateTime($request->request->get('date_time')));
        $session->setLocation($request->request->get('location'));

        $em->flush();

        return $this->json($session);
    }

    #[Route('/{id}', name: 'sessions_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $session = $em->getRepository(Sessions::class)->find($id);

        if (!$session) {
            return $this->json(['error' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($session);
        $em->flush();

        return $this->json(['message' => 'Session deleted']);
    }
}
