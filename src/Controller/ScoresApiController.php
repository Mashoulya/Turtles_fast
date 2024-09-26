<?php

namespace App\Controller;

use App\Entity\Scores;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
            'score' => $score->getScore(),
            'user' => $score->getUser()->getName(),
            'difficulty' => $score->getDifficulty(),
        ];
    }, $scores);

        return new JsonResponse($data);
    }

   
}
