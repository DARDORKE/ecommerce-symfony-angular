<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_auth_')]
class AuthController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Check if user already exists
        $userRepository = $this->entityManager->getRepository(User::class);
        $existingUser = $userRepository->findOneBy(['email' => $data['email']]);
        
        if ($existingUser) {
            return $this->json(['error' => 'User already exists'], 409);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userData = $this->serializer->serialize($user, 'json', ['groups' => 'user:read']);
        return JsonResponse::fromJsonString($userData, 201);
    }

    #[Route('/login_check', name: 'login_check', methods: ['POST'])]
    public function loginCheck(): JsonResponse
    {
        // This method will be handled by the JWT authenticator
        return $this->json(['message' => 'Login successful']);
    }

    #[Route('/me', name: 'me', methods: ['GET'])]
    public function me(): JsonResponse
    {
        $user = $this->getUser();
        $data = $this->serializer->serialize($user, 'json', ['groups' => 'user:read']);
        return JsonResponse::fromJsonString($data);
    }

    #[Route('/test-auth', name: 'test_auth', methods: ['GET'])]
    public function testAuth(): JsonResponse
    {
        // Test endpoint to check if authentication works
        return $this->json([
            'message' => 'Authentication endpoint is working',
            'login_url' => '/api/login_check',
            'method' => 'POST',
            'expected_body' => [
                'username' => 'admin@example.com',
                'password' => 'admin123'
            ],
            'jwt_config' => [
                'private_key_exists' => file_exists('/app/config/jwt-prod/private.pem'),
                'public_key_exists' => file_exists('/app/config/jwt-prod/public.pem'),
                'env_jwt_secret_key' => $_ENV['JWT_SECRET_KEY'] ?? 'NOT_SET',
                'env_jwt_passphrase' => $_ENV['JWT_PASSPHRASE'] ?? 'NOT_SET'
            ]
        ]);
    }
}