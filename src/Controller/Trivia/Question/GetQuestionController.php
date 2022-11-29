<?php

namespace App\Controller\Trivia\Question;

use App\Entity\Question;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetQuestionController extends AbstractController
{

    /**
     * @Method({"GET"})
     * @Route("/question/{id}", name="app_trivia_question")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function getQuestion(ManagerRegistry $doctrine, int $id): Response
    {
        $question = $doctrine->getRepository(Question::class)->find($id);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id '.$id
            );
        }

        return new JsonResponse([
            'id'        => $question->getId(),
            'statement' => $question->getStatement(),
            'category'  => $question->getType(),
            'answers'   => $this->getAnswersByQuestion($question)
        ]);
    }

    /**
     * Get the answers by the Question
     * 
     * @param Question $question
     * 
     * @return array
     */
    private function getAnswersByQuestion(Question $question): array
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
