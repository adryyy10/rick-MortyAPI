<?php

namespace App\Controller\Trivia\Category;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCategoriesController extends AbstractController
{

    /**
     * @Method({"GET"})
     * @Route("/categories", name="app_trivia_categories")
     * 
     * @param ManagerRegistry $doctrine
     * 
     * @return JsonReponse
     */
    public function getCategories(ManagerRegistry $doctrine): Response
    {
        $categories = $doctrine->getRepository(Category::class)->findAll();

        $questionnaire = [];

        if (!empty($categories)) {
            foreach ($categories as $category) {
    
                array_push($questionnaire, [
                    'id'        => $category->getId(),
                    'title'     => $category->getTitle()
                ]);
            }
        }

        return new JsonResponse($questionnaire);
    }

}
