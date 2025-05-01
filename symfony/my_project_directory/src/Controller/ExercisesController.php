<?php

namespace App\Controller;

use App\Entity\Exercises;
use App\Repository\ExercisesRepository;
use App\Repository\ClubMembersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ExercisesController extends AbstractController
{
    private $exercisesRepository;
    private $clubMembersRepository;
    private $entityManager;

    public function __construct(
        ExercisesRepository $exercisesRepository,
        ClubMembersRepository $clubMembersRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->exercisesRepository = $exercisesRepository;
        $this->clubMembersRepository = $clubMembersRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/exercises', name: 'exercises_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $qb = $em->getRepository(Exercises::class)->createQueryBuilder('e');
    
        if ($request->query->get('id')) {
            $qb->andWhere('e.id = :id')->setParameter('id', $request->query->get('id'));
        }
    
        if ($request->query->get('trainerID')) {
            $qb->andWhere('e.trainerID = :trainerID')->setParameter('trainerID', $request->query->get('trainerID'));
        }
    
        if ($request->query->get('exercise')) {
            $qb->andWhere('e.exercise LIKE :exercise')->setParameter('exercise', '%' . $request->query->get('exercise') . '%');
        }
    
        if ($request->query->get('title')) {
            $qb->andWhere('e.title LIKE :title')->setParameter('title', '%' . $request->query->get('title') . '%');
        }
    
        if ($request->query->get('time')) {
            $qb->andWhere('e.time = :time')->setParameter('time', $request->query->get('time'));
        }
    
        $itemsPerPage = $request->query->getInt('itemsPerPage', 10);
        $page = $request->query->getInt('page', 1);
    
        $query = $qb->getQuery()
            ->setFirstResult(($page - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage);
    
        $paginator = new Paginator($query);
    
        return $this->render('exercises/index.html.twig', [
            'exercises' => $paginator,
            'page' => $page,
            'itemsPerPage' => $itemsPerPage,
        ]);
    }

    #[Route('/exercises/new', name: 'exercises_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $exercise = new Exercises();

        if ($request->isMethod('POST')) {
            $exercise->setExercise($request->request->get('exercise'));
            $exercise->setTime($request->request->get('time'));
            $exercise->setTitle($request->request->get('title'));

            $trainerId = $request->request->get('trainer_id');
            $trainer = $this->clubMembersRepository->find($trainerId);
            $exercise->setTrainer($trainer);

            $this->entityManager->persist($exercise);
            $this->entityManager->flush();

            return $this->redirectToRoute('exercises_index');
        }

        $trainers = $this->clubMembersRepository->findBy(['is_trainer' => true]);

        return $this->render('exercises/new.html.twig', [
            'trainers' => $trainers,
        ]);
    }

    #[Route('/exercises/{id}', name: 'exercises_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $exercise = $this->exercisesRepository->find($id);
    
        if (!$exercise) {
            throw $this->createNotFoundException('Упражнение не найдено');
        }
    
        $trainer = $exercise->getTrainer();
    
        return $this->render('exercises/show.html.twig', [
            'exercise' => $exercise,
            'trainer' => $trainer,
        ]);
    }
    

    #[Route('/exercises/{id}/edit', name: 'exercises_edit')]
    public function edit(int $id, Request $request): Response
    {
        $exercise = $this->exercisesRepository->find($id);

        if (!$exercise) {
            throw $this->createNotFoundException('Упражнение не найдено');
        }

        $trainers = $this->clubMembersRepository->findBy(['is_trainer' => true]);

        if ($request->isMethod('POST')) {
            $exercise->setExercise($request->request->get('exercise'));
            $exercise->setTime($request->request->get('time'));
            $exercise->setTitle($request->request->get('title'));

            $trainerId = $request->request->get('trainer_id');
            $trainer = $this->clubMembersRepository->find($trainerId);
            $exercise->setTrainer($trainer);

            $this->entityManager->flush();

            return $this->redirectToRoute('exercises_index');
        }

        return $this->render('exercises/edit.html.twig', [
            'exercise' => $exercise,
            'trainers' => $trainers,
        ]);
    }

    #[Route('/exercises/{id}', name: 'exercises_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        $exercise = $this->exercisesRepository->find($id);

        if (!$exercise) {
            throw $this->createNotFoundException('No exercise found for id ' . $id);
        }

        $this->entityManager->remove($exercise);
        $this->entityManager->flush();

        return $this->redirectToRoute('exercises_index');
    }
}
