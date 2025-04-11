<?php

namespace App\Controller;

use App\Entity\ClubMembers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ClubMembersController extends AbstractController
{
    #[Route('/club_members', name: 'club_members_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $clubMembers = $em->getRepository(ClubMembers::class)->findAll();
        return $this->render('club_members/index.html.twig', [
            'club_members' => $clubMembers,
        ]);
    }

    #[Route('/club_members/new', name: 'club_members_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $clubMember = new ClubMembers();

        if ($request->isMethod('POST')) {
            $clubMember->setFullName($request->request->get('full_name'));
            $clubMember->setLogin($request->request->get('login'));
            $clubMember->setIsTrainer((bool) $request->request->get('is_trainer'));
            $clubMember->setMail($request->request->get('mail'));

            $em->persist($clubMember);
            $em->flush();

            return $this->redirectToRoute('club_members_index');
        }

        return $this->render('club_members/new.html.twig');
    }

    #[Route('/club_members/{id}', name: 'club_members_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $clubMember = $em->getRepository(ClubMembers::class)->find($id);

        if (!$clubMember) {
            throw $this->createNotFoundException('No club member found for id ' . $id);
        }

        return $this->render('club_members/show.html.twig', [
            'club_member' => $clubMember,
        ]);
    }

    #[Route('/club_members/{id}/edit', name: 'club_members_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $clubMember = $em->getRepository(ClubMembers::class)->find($id);

        if (!$clubMember) {
            throw $this->createNotFoundException('No club member found for id ' . $id);
        }

        if ($request->isMethod('POST')) {
            $clubMember->setFullName($request->request->get('full_name'));
            $clubMember->setLogin($request->request->get('login'));
            $clubMember->setIsTrainer((bool) $request->request->get('is_trainer'));
            $clubMember->setMail($request->request->get('mail'));

            $em->flush();

            return $this->redirectToRoute('club_members_index');
        }

        return $this->render('club_members/edit.html.twig', [
            'club_member' => $clubMember,
        ]);
    }

    #[Route('/club_members/{id}', name: 'club_members_delete', methods: ['POST'])]
    public function delete(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $clubMember = $em->getRepository(ClubMembers::class)->find($id);

        if (!$clubMember) {
            throw $this->createNotFoundException('No club member found for id ' . $id);
        }

        $em->remove($clubMember);
        $em->flush();

        return $this->redirectToRoute('club_members_index');
    }
}
