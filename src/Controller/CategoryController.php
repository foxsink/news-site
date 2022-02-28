<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function renderMenu(CategoryRepository $repository): Response
    {
        $lowestUniqueCategories = $repository->getLowerCategories();
        $categoryArray = [];
        foreach ($lowestUniqueCategories as $lowerUniqueCategory) {
            $depth = 0;
            $fullBranch[] = $lowerUniqueCategory;
            while ($upperCategory = $lowerUniqueCategory->getParentCategory()) {

                $fullBranch[] = $upperCategory;
                $lowerUniqueCategory = $upperCategory;
                $depth++;
            }
            $categoryArray[] = $fullBranch;
            $fullBranch = null;
        }
        return $this->render('category/menu.html.twig', [
            'categoryArray' => array_reverse($categoryArray),
        ]);
    }
}