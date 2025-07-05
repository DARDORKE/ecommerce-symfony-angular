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
        try {
            $data = json_decode($request->getContent(), true);
            
            // Validate JSON input
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->json(['error' => 'Invalid JSON'], 400);
            }

            // Validate required fields
            if (!isset($data['email'], $data['firstName'], $data['lastName'], $data['password'])) {
                return $this->json(['error' => 'Missing required fields'], 400);
            }

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
            
        } catch (\Exception $e) {
            // Log the error for debugging
            error_log('Registration error: ' . $e->getMessage());
            
            return $this->json([
                'error' => 'Registration failed',
                'message' => $e->getMessage()
            ], 500);
        }
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
                'secret_configured' => !empty($_ENV['JWT_SECRET'] ?? ''),
                'ttl' => $_ENV['JWT_TTL'] ?? '3600'
            ]
        ]);
    }

    #[Route('/debug-register', name: 'debug_register', methods: ['GET'])]
    public function debugRegister(): JsonResponse
    {
        try {
            // Test database connection
            $connection = $this->entityManager->getConnection();
            $connection->executeQuery('SELECT 1');
            $dbStatus = 'OK';
        } catch (\Exception $e) {
            $dbStatus = 'ERROR: ' . $e->getMessage();
        }

        try {
            // Test User repository
            $userRepository = $this->entityManager->getRepository(User::class);
            $userCount = $userRepository->count([]);
            $repoStatus = 'OK - ' . $userCount . ' users';
        } catch (\Exception $e) {
            $repoStatus = 'ERROR: ' . $e->getMessage();
        }

        try {
            // Test creating a User object
            $testUser = new User();
            $testUser->setEmail('test@example.com');
            $testUser->setFirstName('Test');
            $testUser->setLastName('User');
            $userObjectStatus = 'OK';
        } catch (\Exception $e) {
            $userObjectStatus = 'ERROR: ' . $e->getMessage();
        }

        try {
            // Test password hasher
            $hashedPassword = $this->passwordHasher->hashPassword($testUser, 'test123');
            $passwordHasherStatus = 'OK';
        } catch (\Exception $e) {
            $passwordHasherStatus = 'ERROR: ' . $e->getMessage();
        }

        try {
            // Test validator
            $errors = $this->validator->validate($testUser);
            $validatorStatus = 'OK - ' . count($errors) . ' errors';
        } catch (\Exception $e) {
            $validatorStatus = 'ERROR: ' . $e->getMessage();
        }

        try {
            // Test serializer
            $serialized = $this->serializer->serialize($testUser, 'json', ['groups' => 'user:read']);
            $serializerStatus = 'OK';
        } catch (\Exception $e) {
            $serializerStatus = 'ERROR: ' . $e->getMessage();
        }

        return $this->json([
            'database' => $dbStatus,
            'user_repository' => $repoStatus,
            'user_object' => $userObjectStatus,
            'password_hasher' => $passwordHasherStatus,
            'validator' => $validatorStatus,
            'serializer' => $serializerStatus,
            'environment' => $_ENV['APP_ENV'] ?? 'NOT_SET'
        ]);
    }
}