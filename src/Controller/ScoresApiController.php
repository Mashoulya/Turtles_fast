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

    #[Route('/users/{id}/scores/api', name: 'app_user_scores_api')]
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
                'created_at' => $score->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $score->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse($data);
    }
}
