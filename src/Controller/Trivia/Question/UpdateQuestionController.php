<?php

namespace App\Controller\Trivia\Question;

use App\Entity\Question;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateQuestionController extends AbstractController
{

    /**
     * 
     * @Route("/question/{id}", methods={"PUT"}, name="app_trivia_update_question")
     * 
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function updateQuestion(
        Request $request,
        ManagerRegistry $doctrine, 
        int $id
    ): Response {

        /** We cannot update unless we are ROLE_SUPER_ADMIN */
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to update without having ROLE_SUPER_ADMIN');       

        $entityManager  = $doctrine->getManager();
        $question       = $doctrine->getRepository(Question::class)->find($id);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id '.$id
            );
        }

        /** Getting data from request */
        $statement = $request->get('statement');
        $type      = $request->get('type');

        /** Update in DB */
        Question::addOrUpdate($question, $statement, $type);
        $entityManager->persist($question);
        $entityManager->flush();

        return new JsonResponse(
            ["message" => "Updated"], 
            Response::HTTP_OK
        );
    }

}
