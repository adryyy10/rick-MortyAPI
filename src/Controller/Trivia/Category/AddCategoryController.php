<?php

namespace App\Controller\Trivia\Category;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddCategoryController extends AbstractController
{

    /**
     * @Route("/category", methods={"POST"}, name="app_trivia_add_category")
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
        $title = $request->get('title');

        /** Add in DB */
        $category = Category::addOrUpdate(null, $title);
        $entityManager->persist($category);
        $entityManager->flush();

        return new Response('Saved new category with id '. $category->getId());
    }

}
