<?php

namespace App\Controller;

use App\Repository\QuestionsRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionsApiController extends AbstractController
{
    #[Route('/api/questions', name: 'api_questions', methods: ['GET'])]
    public function getQuestions(QuestionsRepository $questionsRepository): JsonResponse
    {

        // on récupère de la BDD
        $questions = $questionsRepository->findAll();


        //on transforme en tableau
        $questionsArray = [];

        foreach ($questions as $question) {
            $questionsArray[] = [
                'id' => $question->getId(),
                'title' => $question->getTitle(),
                'question' => $question->getQuestion(),
                'answers' => [
                    'correct' => $question->getAnswer(),
                    'false1' => $question->getFalseAnswer1(),
                    'false2' => $question->getFalseAnswer2(),
                    'false3' => $question->getFalseAnswer3(),
                ],
                
            ];
        }
        return $this->json($questionsArray);
    }
}
