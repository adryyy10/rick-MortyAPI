<?php

namespace App\Controller\Trivia\Answer;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddAnswerController extends AbstractController
{

    /**
     * @Route("/answer", methods={"POST"}, name="app_trivia_add_answer")
     * 
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * 
     * @return JsonReponse
     */
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        /** We cannot update unless we are ROLE_SUPER_ADMIN */
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to add without having ROLE_SUPER_ADMIN');

        $entityManager = $doctrine->getManager();

        /** Getting data from request */
        $title      = $request->get('title');
        $isCorrect  = (bool)$request->get('isCorrect');
        $questionId = (int)$request->get('questionId');

        /** Getting the question via questionId */
        $question = $doctrine->getRepository(Question::class)->find($questionId);

        if (empty($question)) {
            throw new EntityNotFoundException("Question not found");
        }

        $answer = Answer::addOrUpdate(null, $title, $isCorrect, $question);
        $entityManager->persist($answer);
        $entityManager->flush();

        return new Response('Saved new answer with id '.$answer->getId());
    }

}
