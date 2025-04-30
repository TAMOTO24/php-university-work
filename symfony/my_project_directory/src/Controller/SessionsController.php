<?php
namespace App\Controller;

use App\Entity\Sessions;
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
        return $this->render('sessions/index.html.twig', [
            'sessions' => $sessions
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
