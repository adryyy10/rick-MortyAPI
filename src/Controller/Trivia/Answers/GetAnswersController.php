<?php

namespace App\Controller\Trivia\Answers;

use App\Entity\Answer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAnswersController extends AbstractController
{

    /**
     * @Route("/answers", name="app_trivia_answers")
     * 
     * @param ManagerRegistry $doctrine
     * 
     * @return JsonReponse
     */
    public function getAnswers(ManagerRegistry $doctrine): Response
    {
        $answers = $doctrine->getRepository(Answer::class)->findAll();

        $questionnaire = [];

        if (!empty($answers)) {
            foreach ($answers as $answer) {
    
                array_push($questionnaire, [
                    'id'        => $answer->getId(),
                    'title'     => $answer->getTitle(),
                    'isCorrect' => $answer->getIsCorrect(),
                    'question'  => $this->getQuestionByAnswer($answer)
                ]);
            }
        }

        return new JsonResponse($questionnaire);
    }

    private function getQuestionByAnswer(Answer $answer): array
    {
        $question = $answer->getQuestion();
        return [
            'id'        => $question->getId(),
            'statement' => $question->getStatement(),
            'type'      => $question->getType()
        ];
    }

}
