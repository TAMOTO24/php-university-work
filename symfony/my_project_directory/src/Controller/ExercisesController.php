<?php

namespace App\Controller;

use App\Entity\Exercises;
use App\Entity\ClubMembers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/exercises")
 */
class ExercisesController extends AbstractController
{
    /**
     * @Route("/", name="exercises_index", methods={"GET"})
     */
    #[Route('/', name: 'exercises_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $exercises = $em->getRepository(Exercises::class)->findAll();
        return $this->render('exercises/index.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    /**
     * @Route("/new", name="exercises_new", methods={"POST"})
     */
    #[Route('/new', name: 'exercises_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $trainer = $em->getRepository(ClubMembers::class)->find($request->request->get('trainerID'));

        if (!$trainer) {
            return $this->json(['error' => 'Trainer not found'], Response::HTTP_BAD_REQUEST);
        }

        $exercise = new Exercises();
        $exercise->setTrainer($trainer);
        $exercise->setExercise($request->request->get('exercise'));
        $exercise->setTime((int) $request->request->get('time'));
        $exercise->setTitle($request->request->get('title'));

        $em->persist($exercise);
        $em->flush();

        return $this->json($exercise, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="exercises_show", methods={"GET"})
     */
    #[Route('/{id}', name: 'exercises_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $exercise = $em->getRepository(Exercises::class)->find($id);

        if (!$exercise) {
            return $this->json(['error' => 'Exercise not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($exercise);
    }

    /**
     * @Route("/{id}/edit", name="exercises_edit", methods={"POST"})
     */
    #[Route('/{id}/edit', name: 'exercises_edit', methods: ['POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $exercise = $em->getRepository(Exercises::class)->find($id);

        if (!$exercise) {
            return $this->json(['error' => 'Exercise not found'], Response::HTTP_NOT_FOUND);
        }

        $trainer = $em->getRepository(ClubMembers::class)->find($request->request->get('trainerID'));
        if ($trainer) {
            $exercise->setTrainer($trainer);
        }

        $exercise->setExercise($request->request->get('exercise'));
        $exercise->setTime((int) $request->request->get('time'));
        $exercise->setTitle($request->request->get('title'));

        $em->flush();

        return $this->json($exercise);
    }

    /**
     * @Route("/{id}", name="exercises_delete", methods={"POST"})
     */
    #[Route('/{id}', name: 'exercises_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $exercise = $em->getRepository(Exercises::class)->find($id);

        if (!$exercise) {
            return $this->json(['error' => 'Exercise not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($exercise);
        $em->flush();

        return $this->json(['message' => 'Exercise deleted']);
    }
}
