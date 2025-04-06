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
    #[Route('/test/message', name: 'app_test_message')] //Перетворює просту відповідь Response на рядок «Це тестове повідомлення в TestController!».
    public function testMessage(): Response
    {
        return new Response('Test message from TestController!');
    }

    #[Route('/test/create', name: 'app_test_create')]
    public function create(): Response
    {
        // Створюємо нове "повідомлення" (симуляція)
        $message = 'This is a new message';

        // "Симулюємо" додавання в базу (ми просто виводимо результат)
        return new Response('Message created with text: ' . $message);
    }

    #[Route('/test/{id}', name: 'app_test_read')]
    public function read($id): Response
    {
        // "Симулюємо" пошук повідомлення за id
        $message = "Message with ID $id"; // Це можна змінити на будь-який текст

        return new Response('Message: ' . $message);
    }

    #[Route('/test/update/{id}', name: 'app_test_update')]
    public function update($id): Response
    {
        // "Симулюємо" оновлення повідомлення
        $updatedMessage = "Updated message for ID $id";

        return new Response('Message updated to: ' . $updatedMessage);
    }

    #[Route('/test/delete/{id}', name: 'app_test_delete')]
    public function delete($id): Response
    {
        // "Симулюємо" видалення повідомлення
        return new Response('Message with ID ' . $id . ' has been deleted!');
    }
}
