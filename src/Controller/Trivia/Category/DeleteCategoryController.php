<?php

namespace App\Controller\Trivia\Category;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteCategoryController extends AbstractController
{

    /**
     * @Route("/category/{id}", methods={"DELETE"}, name="app_trivia_delete_category")
     * 
     * @param ManagerRegistry $doctrine
     * @param int $id
     * 
     * @return JsonReponse
     */
    public function deleteCategory(ManagerRegistry $doctrine, int $id): Response
    {

        /** We cannot update unless we are ROLE_SUPER_ADMIN */
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to add without having ROLE_SUPER_ADMIN');

        $category = $doctrine->getRepository(Category::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        /** Delete */
        $entityManager = $doctrine->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        return new Response('Deleted category');
    }

}
