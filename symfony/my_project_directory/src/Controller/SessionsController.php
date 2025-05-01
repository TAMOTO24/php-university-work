<?php
namespace App\Controller;

use App\Entity\Sessions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;

#[Route('/sessions')]
class SessionsController extends AbstractController
{
    #[Route('/', name: 'sessions_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $qb = $em->getRepository(Sessions::class)->createQueryBuilder('s');

        if ($request->query->get('id')) {
            $qb->andWhere('s.id = :id')->setParameter('id', $request->query->get('id'));
        }

        if ($request->query->get('exercise_id')) {
            $qb->andWhere('s.exercise_id = :exercise_id')->setParameter('exercise_id', $request->query->get('exercise_id'));
        }

        if ($request->query->get('trainer_id')) {
            $qb->andWhere('s.trainer_id = :trainer_id')->setParameter('trainer_id', $request->query->get('trainer_id'));
        }

        if ($request->query->get('date_time')) {
            $qb->andWhere('s.date_time = :date_time')->setParameter('date_time', $request->query->get('date_time'));
        }

        if ($request->query->get('location')) {
            $qb->andWhere('s.location LIKE :location')->setParameter('location', '%' . $request->query->get('location') . '%');
        }

        if ($request->query->get('name')) {
            $qb->andWhere('s.name LIKE :name')->setParameter('name', '%' . $request->query->get('name') . '%');
        }

        $itemsPerPage = $request->query->getInt('itemsPerPage', 10);
        $page = $request->query->getInt('page', 1);

        $query = $qb->getQuery()
            ->setFirstResult(($page - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage);

        $paginator = new Paginator($query);

        return $this->render('sessions/index.html.twig', [
            'sessions' => $paginator,
            'page' => $page,
            'itemsPerPage' => $itemsPerPage,
        ]);
    }
    #[Route('/new', name: 'sessions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $dateTime = new \DateTime($request->request->get('date_time'));
            $location = $request->request->get('location');

            if (empty($name)) {
                return $this->json(['error' => 'Name is required'], Response::HTTP_BAD_REQUEST);
            }

            $session = new Sessions();
            $session->setName($name);
            $session->setDateTime($dateTime);
            $session->setLocation($location);

            $em->persist($session);
            $em->flush();

            return $this->redirectToRoute('sessions_index');
        }

        return $this->render('sessions/new.html.twig');
    }

    #[Route('/{id}', name: 'sessions_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $session = $em->getRepository(Sessions::class)->find($id);

        if (!$session) {
            return $this->json(['error' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->render('sessions/show.html.twig', [
            'session' => $session
        ]);
    }

    #[Route('/{id}/edit', name: 'sessions_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $session = $em->getRepository(Sessions::class)->find($id);

        if (!$session) {
            return $this->json(['error' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $dateTime = new \DateTime($request->request->get('date_time'));
            $location = $request->request->get('location');

            $session->setName($name);
            $session->setDateTime($dateTime);
            $session->setLocation($location);

            $em->flush();

            return $this->redirectToRoute('sessions_index');
        }

        $formattedDateTime = $session->getDateTime()->format('Y-m-d\TH:i');

        return $this->render('sessions/edit.html.twig', [
            'session' => $session,
            'formattedDateTime' => $formattedDateTime,
        ]);
    }
    #[Route('/{id}', name: 'sessions_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $session = $em->getRepository(Sessions::class)->find($id);

        if (!$session) {
            return $this->json(['error' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($session);
        $em->flush();

        return $this->redirectToRoute('sessions_index');
    }
}
