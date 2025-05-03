<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->json(['message' => 'Email and password are required.'], 400);
        }

        $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            return $this->json(['message' => 'User already exists.'], 409);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword($user, $password));
        $user->setRoles(['ROLE_CLIENT']);

        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'User registered successfully.'], 201);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        try {
            $data = json_decode($request->getContent(), true);

            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;

            if (!$email || !$password) {
                return $this->json(['message' => 'Email and password are required.'], 400);
            }

            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
                return $this->json(['message' => 'Invalid credentials'], 401);
            }

            $token = $jwtManager->create($user);

            return $this->json(['token' => $token]);
        } catch (\Exception $e) {
            return $this->json(['message' => 'An error occurred during login: ' . $e->getMessage()], 500);
        }
    }

    #[Route('/api/client', name: 'api_client', methods: ['GET'])]
    public function client(): JsonResponse
    {
        return $this->json(['message' => 'Client route accessed']);
    }

    #[Route('/api/admin', name: 'api_admin', methods: ['GET'])]
    public function admin(): JsonResponse
    {
        return $this->json(['message' => 'Admin route accessed']);
    }

    #[Route('/api/user', name: 'api_user', methods: ['GET'])]
    public function user(): JsonResponse
    {
        return $this->json(['message' => 'User route accessed']);
    }

    #[Route('/api/manager', name: 'api_manager', methods: ['GET'])]
    public function manager(): JsonResponse
    {
        return $this->json(['message' => 'Manager route accessed']);
    }
}

