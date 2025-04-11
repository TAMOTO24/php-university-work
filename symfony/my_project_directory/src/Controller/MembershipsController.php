<?php

namespace App\Controller;

use App\Entity\ClubMembers;
use App\Entity\Sessions;
use App\Entity\Memberships;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/memberships')]
class MembershipsController extends AbstractController
{
    #[Route('/', name: 'memberships_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $memberships = $em->getRepository(Memberships::class)->findAll();
        return $this->json($memberships);
    }

    #[Route('/new', name: 'memberships_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $member = $em->getRepository(ClubMembers::class)->find($request->request->get('member_id'));
        $session = $em->getRepository(Sessions::class)->find($request->request->get('session_id'));

        if (!$member || !$session) {
            return $this->json(['error' => 'Member or Session not found'], Response::HTTP_BAD_REQUEST);
        }

        $membership = new Memberships();
        $membership->setMember($member);
        $membership->setSession($session);

        $em->persist($membership);
        $em->flush();

        return $this->json($membership, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'memberships_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $membership = $em->getRepository(Memberships::class)->find($id);

        if (!$membership) {
            return $this->json(['error' => 'Membership not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($membership);
    }

    #[Route('/{id}/edit', name: 'memberships_edit', methods: ['POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $membership = $em->getRepository(Memberships::class)->find($id);

        if (!$membership) {
            return $this->json(['error' => 'Membership not found'], Response::HTTP_NOT_FOUND);
        }

        $member = $em->getRepository(ClubMembers::class)->find($request->request->get('member_id'));
        $session = $em->getRepository(Sessions::class)->find($request->request->get('session_id'));

        if ($member) {
            $membership->setMember($member);
        }
        if ($session) {
            $membership->setSession($session);
        }

        $em->flush();

        return $this->json($membership);
    }

    #[Route('/{id}', name: 'memberships_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $membership = $em->getRepository(Memberships::class)->find($id);

        if (!$membership) {
            return $this->json(['error' => 'Membership not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($membership);
        $em->flush();

        return $this->json(['message' => 'Membership deleted']);
    }
}
