<?php

namespace App\Controller;

use App\Entity\ClubMembers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ClubMembersController extends AbstractController
{
    #[Route('/club_members', name: 'club_members_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $qb = $em->getRepository(ClubMembers::class)->createQueryBuilder('c');

        if ($request->query->get('id')) {
            $qb->andWhere('c.id = :id')->setParameter('id', $request->query->get('id'));
        }

        if ($request->query->get('fullName')) {
            $qb->andWhere('c.fullName LIKE :fullName')->setParameter('fullName', '%' . $request->query->get('fullName') . '%');
        }

        if ($request->query->get('login')) {
            $qb->andWhere('c.login LIKE :login')->setParameter('login', '%' . $request->query->get('login') . '%');
        }

        if ($request->query->get('isTrainer') !== null) {
            $qb->andWhere('c.isTrainer = :isTrainer')->setParameter('isTrainer', (bool) $request->query->get('isTrainer'));
        }

        if ($request->query->get('mail')) {
            $qb->andWhere('c.mail LIKE :mail')->setParameter('mail', '%' . $request->query->get('mail') . '%');
        }

        $itemsPerPage = $request->query->getInt('itemsPerPage', 10);
        $page = $request->query->getInt('page', 1);

        $query = $qb->getQuery()
            ->setFirstResult(($page - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage);

        $paginator = new Paginator($query);

        return $this->render('club_members/index.html.twig', [
            'club_members' => $paginator,
            'page' => $page,
            'itemsPerPage' => $itemsPerPage,
        ]);
    }

    #[Route('/club_members/new', name: 'club_members_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $clubMember = new ClubMembers();

        if ($request->isMethod('POST')) {
            $fullName = $request->request->get('full_name');
            $login = $request->request->get('login');
            $isTrainer = (bool) $request->request->get('is_trainer');
            $mail = $request->request->get('mail');

            if (empty($fullName) || empty($login) || empty($mail)) {
                $this->addFlash('error', 'Всі поля повинні бути заповнені.');
                return $this->redirectToRoute('club_members_new');
            }

            $clubMember->setFullName($fullName);
            $clubMember->setLogin($login);
            $clubMember->setIsTrainer($isTrainer);
            $clubMember->setMail($mail);

            $em->persist($clubMember);
            $em->flush();

            $this->addFlash('success', 'Учасника додано успішно!');
            return $this->redirectToRoute('club_members_index');
        }

        return $this->render('club_members/new.html.twig');
    }

    #[Route('/club_members/{id}', name: 'club_members_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $clubMember = $em->getRepository(ClubMembers::class)->find($id);

        if (!$clubMember) {
            throw $this->createNotFoundException('Немає учасника з таким ID');
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
            throw $this->createNotFoundException('Немає учасника з таким ID');
        }

        if ($request->isMethod('POST')) {
            $fullName = $request->request->get('full_name');
            $login = $request->request->get('login');
            $isTrainer = (bool) $request->request->get('is_trainer');
            $mail = $request->request->get('mail');

            if (empty($fullName) || empty($login) || empty($mail)) {
                $this->addFlash('error', 'Всі поля повинні бути заповнені.');
                return $this->redirectToRoute('club_members_edit', ['id' => $id]);
            }

            $clubMember->setFullName($fullName);
            $clubMember->setLogin($login);
            $clubMember->setIsTrainer($isTrainer);
            $clubMember->setMail($mail);

            $em->flush();

            $this->addFlash('success', 'Зміни збережено успішно!');
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
            throw $this->createNotFoundException('Немає учасника з таким ID');
        }

        if ($request->isMethod('POST') && $this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em->remove($clubMember);
            $em->flush();

            $this->addFlash('success', 'Учасник успішно видалений!');
        }

        return $this->redirectToRoute('club_members_index');
    }
}
