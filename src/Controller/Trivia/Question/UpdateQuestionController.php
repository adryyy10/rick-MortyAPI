<?php

namespace App\Controller\Trivia\Question;

use App\Entity\Question;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateQuestionController extends AbstractController
{

    /**
     * 
     * @Method({"PUT"})
     * @Route("/question/{id}", name="app_trivia_question")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function update(
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

        $question->setStatement($statement);
        $question->setType($type);
        $entityManager->flush();

        return new JsonResponse(
            ["message" => "Updated"], 
            Response::HTTP_OK
        );
    }

}
