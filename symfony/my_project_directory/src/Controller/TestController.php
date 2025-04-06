<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/test/message', name: 'app_test_message')] //Turns the simple Response response with the line "This test message is in TestController!".
    public function testMessage(): Response
    {
        return new Response('Test message from TestController!');
    }
}
