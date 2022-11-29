<?php

namespace App\Controller\Trivia\Answer;

use App\Entity\Answer;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAnswerController extends AbstractController
{

    /**
     * @Method({"GET"})
     * @Route("/answer/{id}", name="app_trivia_answer")
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
