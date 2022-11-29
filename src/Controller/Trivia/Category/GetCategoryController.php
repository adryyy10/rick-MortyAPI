<?php

namespace App\Controller\Trivia\Category;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCategoryController extends AbstractController
{

    /**
     * @Method({"GET"})
     * @Route("/category/{id}", name="app_trivia_category")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function getCategory(ManagerRegistry $doctrine, int $id): Response
    {
        $category = $doctrine->getRepository(Category::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        return new JsonResponse([
            'id'        => $category->getId(),
            'title'     => $category->getTitle()
        ]);
    }

}
