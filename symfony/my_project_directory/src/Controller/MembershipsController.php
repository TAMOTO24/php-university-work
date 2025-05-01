<?php
namespace App\Controller;

use App\Entity\Memberships;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\Tools\Pagination\Paginator;

#[Route('/memberships')]
class MembershipsController extends AbstractController
{
    #[Route('/', name: 'memberships_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $qb = $em->getRepository(Memberships::class)->createQueryBuilder('m');
    
        if ($request->query->get('id')) {
            $qb->andWhere('m.id = :id')->setParameter('id', $request->query->get('id'));
        }
    
        if ($request->query->get('name')) {
            $qb->andWhere('m.name LIKE :name')->setParameter('name', '%' . $request->query->get('name') . '%');
        }
    
        if ($request->query->get('title')) {
            $qb->andWhere('m.title LIKE :title')->setParameter('title', '%' . $request->query->get('title') . '%');
        }
    
        if ($request->query->get('description')) {
            $qb->andWhere('m.description LIKE :description')->setParameter('description', '%' . $request->query->get('description') . '%');
        }
    
        $itemsPerPage = $request->query->getInt('itemsPerPage', 10);
        $page = $request->query->getInt('page', 1);
    
        $query = $qb->getQuery()
            ->setFirstResult(($page - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage);
    
        $paginator = new Paginator($query);
    
        return $this->render('memberships/index.html.twig', [
            'memberships' => $paginator,
            'page' => $page,
            'itemsPerPage' => $itemsPerPage,
        ]);
    }

    #[Route('/new', name: 'memberships_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $title = $request->request->get('title');
            $description = $request->request->get('description');

            $membership = new Memberships();
            $membership->setName($name);
            $membership->setTitle($title);
            $membership->setDescription($description);

            $em->persist($membership);
            $em->flush();

            return $this->redirectToRoute('memberships_index');
        }

        return $this->render('memberships/new.html.twig');
    }

    #[Route('/{id}/edit', name: 'memberships_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $membership = $em->getRepository(Memberships::class)->find($id);

        if (!$membership) {
            return $this->json(['error' => 'Membership not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $title = $request->request->get('title');
            $description = $request->request->get('description');

            $membership->setName($name);
            $membership->setTitle($title);
            $membership->setDescription($description);

            $em->flush();

            return $this->redirectToRoute('memberships_index');
        }

        return $this->render('memberships/edit.html.twig', [
            'membership' => $membership
        ]);
    }

    #[Route('/{id}', name: 'memberships_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $membership = $em->getRepository(Memberships::class)->find($id);

        if (!$membership) {
            return $this->json(['error' => 'Membership not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->render('memberships/view.html.twig', [
            'membership' => $membership
        ]);
    }

    #[Route('/{id}', name: 'memberships_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $membership = $em->getRepository(Memberships::class)->find($id);
    
        if ($membership) {
            $em->remove($membership);
            $em->flush();
        }
    
        return $this->redirectToRoute('memberships_index');
    }
    
}

