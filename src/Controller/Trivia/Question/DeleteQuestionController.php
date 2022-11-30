<?php

namespace App\Controller\Trivia\Question;

use App\Entity\Question;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteQuestionController extends AbstractController
{

    /**
     * @Route("/question/{id}", methods={"DELETE"}, name="app_trivia_delete_question")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function deleteQuestion(ManagerRegistry $doctrine, int $id): Response
    {

        /** We cannot update unless we are ROLE_SUPER_ADMIN */
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to add without having ROLE_SUPER_ADMIN');

        $question = $doctrine->getRepository(Question::class)->find($id);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id '.$id
            );
        }

        /** Delete */
        $entityManager = $doctrine->getManager();
        $entityManager->remove($question);
        $entityManager->flush();

        return new Response('Deleted question');
    }

}
