<?php

namespace App\Controller\Trivia\Category;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateCategoryController extends AbstractController
{

    /**
     * @Route("/category/{id}", methods={"PUT"}, name="app_trivia_update_category")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function updateCategory(
        Request $request,
        ManagerRegistry $doctrine, 
        int $id
    ): Response {

        /** We cannot update unless we are ROLE_SUPER_ADMIN */
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to update without having ROLE_SUPER_ADMIN');       

        $entityManager  = $doctrine->getManager();
        $category       = $doctrine->getRepository(Category::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        /** Getting data from request */
        $title = $request->get('title');

        /** Update in DB */
        Category::addOrUpdate($category, $title);
        $entityManager->persist($category);
        $entityManager->flush();

        return new JsonResponse(
            ["message" => "Updated"], 
            Response::HTTP_OK
        );
    }

}
