<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Scores;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScoresApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/users/{id}/scores', name: 'app_user_scores')]
    public function index(int $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(Users::class)->find($id);
        
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $scores = $user->getScores();
        $data = [];

        foreach ($scores as $score) {
            $data[] = [
                'id' => $score->getId(),
                'score' => $score->getScore(),
                'difficulty' => $score->getDifficulty(),
                'created_at' => $score->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $score->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/scores', name: 'app_api_scores')]

    public function allScores(): JsonResponse {

    $scores = $this->entityManager->getRepository(Scores::class)->findAll();
    
    $data = array_map(function($score) {
        return [
            'id' => $score->getId(),
            'user_id' => $score->getUser()->getId(),
            'score' => $score->getScore(),
            'user' => $score->getUser()->getName(),
            'difficulty' => $score->getDifficulty(),
        ];
    }, $scores);

        return new JsonResponse($data);
    }

    #[Route('/api/add_scores', name: 'app_api_add_scores', methods: ['POST'])]

    public function createScore(Request $request): JsonResponse {
    $data = json_decode($request->getContent(), true);
    
    if (!isset($data['score'], $data['user_id'], $data['difficulty'])) {
        return new JsonResponse(['error' => 'Données manquantes.'], JsonResponse::HTTP_BAD_REQUEST);
    }
    
    $user = $this->entityManager->getRepository(Users::class)->find($data['user_id']);
    if (!$user) {
        return new JsonResponse(['error' => 'Utilisateur non trouvé.'], JsonResponse::HTTP_BAD_REQUEST);
    }
    
    $score = new Scores();
    $score->setScore($data['score']);
    $score->setDifficulty($data['difficulty']);
    $score->setUser($user);
    
    $now = new \DateTimeImmutable();
    $score->setCreatedAt($now);
    $score->setUpdatedAt($now);
    
    $this->entityManager->persist($score);
    $this->entityManager->flush();
    
    return new JsonResponse(['message' => 'Score enregistré avec succès !'], JsonResponse::HTTP_CREATED);
    }
}
