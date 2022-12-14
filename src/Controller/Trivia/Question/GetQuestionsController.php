<?php

namespace App\Controller\Trivia\Question;

use App\Entity\Question;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetQuestionsController extends AbstractController
{

    /**
     * @Route("/questions", methods={"GET"}, name="app_trivia_get_questions")
     * 
     * @param ManagerRegistry $doctrine
     * 
     * @return JsonReponse
     */
    public function getQuestions(ManagerRegistry $doctrine): Response
    {
        $questions = $doctrine->getRepository(Question::class)->findAll();

        $questionnaire = [];

        if (!empty($questions)) {
            foreach ($questions as $question) {

                $answers = $this->getAnswersByQuestionAsArray($question);
    
                array_push($questionnaire, [
                    'id'        => $question->getId(),
                    'title'     => $question->getStatement(),
                    'category'  => $question->getType(),
                    'answers'   => $answers
                ]);
            }
        }

        return new JsonResponse($questionnaire);
    }

    /**
     * Get the answers by the Question as an array instead of a Collection
     * 
     * @param Question $question
     * 
     * @return array
     */
    private function getAnswersByQuestionAsArray(Question $question): array
    {
        $answers            = [];
        $questionAnswers    = $question->getAnswers();

        if (!empty($questionAnswers)) {
            foreach ($questionAnswers as $answer) {
                array_push($answers, [
                    'id'        => $answer->getId(),
                    'title'     => $answer->getTitle(),
                    'isCorrect' => $answer->getIsCorrect()
                ]);
            }
        }

        return $answers;
    }

}
