<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UsersApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/users/api', name: 'app_users_api')]
    public function index(): JsonResponse
    {
        $users = $this->entityManager->getRepository(Users::class)->findAll();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'mail' => $user->getMail(),
                'score' => $user->getScores(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/users/api/create', name: 'app_users_api_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
       
        $data = json_decode($request->getContent(), true);
        var_dump($data['name']);

        if (!isset($data['name'], $data['mail'], $data['password'], $data['turtles_id'])) {
            return new JsonResponse(['error' => 'Données manquantes.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = new Users();
        $user->setName($data['name']);
        $user->setMail($data['mail']);
    
        $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        $now = new \DateTimeImmutable();
        $user->setCreatedAt($now);
        $user->setUpdatedAt($now);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'User created successfully!'], Response::HTTP_CREATED);
    }

    #[Route('/api/login', name: 'app_users_api_login', methods: ['POST'])]
public function login(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    if (!isset($data['mail'], $data['password'])) {
        return new JsonResponse(['error' => 'Données manquantes.'], JsonResponse::HTTP_BAD_REQUEST);
    }

    $user = $this->entityManager->getRepository(Users::class)->findOneBy(['mail' => $data['mail']]);

    if (!$user) {
        return new JsonResponse(['status' => 'error', 'message' => 'Email ou mot de passe incorrect'], JsonResponse::HTTP_UNAUTHORIZED);
    }

    if (!$this->passwordHasher->isPasswordValid($user, $data['password'])) {
        return new JsonResponse(['status' => 'error', 'message' => 'Email ou mot de passe incorrect'], JsonResponse::HTTP_UNAUTHORIZED);
    }

    return new JsonResponse([
        'status' => 'success',
        'message' => 'Vous êtes connecté',
        'user' => [
            'name' => $user->getName(),
            'id' => $user->getId(),
            'mail' => $user->getMail()
        ]
    ]);
}

}
