<?php

namespace App\Controller\Trivia\Answer;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateAnswerController extends AbstractController
{

    /**
     * @Route("/answer/{id}", methods={"PUT"}, name="app_trivia_update_answer")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function updateAnswer(
        Request $request,
        ManagerRegistry $doctrine, 
        int $id
    ): Response {

        /** We cannot update unless we are ROLE_SUPER_ADMIN */
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to update without having ROLE_SUPER_ADMIN');       

        $entityManager  = $doctrine->getManager();
        $answer         = $doctrine->getRepository(Answer::class)->find($id);

        if (!$answer) {
            throw $this->createNotFoundException(
                'No answer found for id '.$id
            );
        }

        /** Getting data from request */
        $title      = $request->get('title');
        $isCorrect  = (bool)$request->get('isCorrect');
        $questionId = (int)$request->get('questionId');

        /** Getting the question via questionId */
        $question = $doctrine->getRepository(Question::class)->find($questionId);

        if (empty($question)) {
            throw new EntityNotFoundException("Question not found");
        }

        /** Update in DB */
        $answer = Answer::addOrUpdate($answer, $title, $isCorrect, $question);
        $entityManager->persist($answer);
        $entityManager->flush();

        return new JsonResponse(
            ["message" => "Updated"], 
            Response::HTTP_OK
        );
    }

}
