<?php

namespace App\Controller\Trivia\Answer;

use App\Entity\Answer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DeleteAnswerController extends AbstractController
{

    /**
     * @Route("/answer/{id}", methods={"DELETE"}, name="app_trivia_delete_answer")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function deleteAnswer(ManagerRegistry $doctrine, int $id): Response
    {

        /** We cannot update unless we are ROLE_SUPER_ADMIN */
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to add without having ROLE_SUPER_ADMIN');

        $answer = $doctrine->getRepository(Answer::class)->find($id);

        if (!$answer) {
            throw $this->createNotFoundException(
                'No answer found for id '.$id
            );
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($answer);
        $entityManager->flush();

        return new Response('Deleted answer');
    }

}
