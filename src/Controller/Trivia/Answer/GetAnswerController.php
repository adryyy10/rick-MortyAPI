<?php

namespace App\Controller\Trivia\Answer;

use App\Entity\Answer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAnswerController extends AbstractController
{

    /**
     * @Route("/answer/{id}", methods={"GET"}, name="app_trivia_get_answer")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function getAnswer(ManagerRegistry $doctrine, int $id): Response
    {
        $answer = $doctrine->getRepository(Answer::class)->find($id);

        if (!$answer) {
            throw $this->createNotFoundException(
                'No answer found for id '.$id
            );
        }

        return new JsonResponse([
            'id'        => $answer->getId(),
            'title'     => $answer->getTitle(),
            'question'  => $this->getQuestionByAnswer($answer)
        ]);
    }

    /**
     * Get question by Answer as an array instead of a collection
     * 
     * @param Answer $answer
     * 
     * @return array
     */
    private function getQuestionByAnswer(Answer $answer): array
    {
        $question = $answer->getQuestion();

        if (empty($question)) return [];

        return [
            'id'        => $question->getId(),
            'statement' => $question->getStatement(),
            'type'      => $question->getType()
        ];
    }

}
