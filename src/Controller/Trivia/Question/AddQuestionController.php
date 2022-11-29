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

class AddQuestionController extends AbstractController
{

    /**
     * 
     * @Method({"POST"})
     * @Route("/question", name="app_trivia_add_question")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function add(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {

        /** We cannot update unless we are ROLE_SUPER_ADMIN */
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to update without having ROLE_SUPER_ADMIN');
        
        $entityManager = $doctrine->getManager();

        /** Getting data from request */
        $statement = $request->get('statement');
        $type      = (int)$request->get('type');

        /** Add in DB */
        $question = Question::addOrUpdate(null, $statement, $type);
        $entityManager->persist($question);
        $entityManager->flush();

        return new Response('Saved new question with id '.$question->getId());
    }

}
