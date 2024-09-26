<?php

namespace App\Controller;

use App\Entity\Turtles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TurtlesApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/turtles', name: 'app_api_turtles')]
    public function index(): JsonResponse
    {
        $turtles = $this->entityManager->getRepository(Turtles::class)->findAll();
        $data = [];

        foreach ($turtles as $turtle) {
            $data[] = [
                'id' => $turtle->getId(),
                'name' => $turtle->getName(),
                'url_img' => $turtle->getUrlImg(),
            ];
        }

        // JSON
        return new JsonResponse($data);
    }
    
}

