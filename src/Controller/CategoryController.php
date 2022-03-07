<?php


namespace App\Controller;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Common\DataFixtures\Exception\CircularReferenceException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @throws CircularReferenceException
     */
    public function renderMenu(CategoryRepository $repository): Response
    {
        /*
         * Solution in general, also it can be solved in more optimized way.
         * For example you can use ajax from front to load new categories, so it will be much easier.
         * But in this situation you can't see whole tree from the start, you will have to click a lot.
         */
        $categories = $repository->getCategoriesWithPosts();
        $categoriesClone = $categories;
        $trees = [];
        foreach ($categoriesClone as $category) {
            $branch = [];
            $depth = 0;
            while ($parent = $category->getParentCategory()) {
                if (in_array($parent, $branch)) {
                    throw new CircularReferenceException('Circular reference!');
                }
                if (in_array($parent, $categories)) {
                    $branch[$parent->getId()] = $category;
                    $category = $parent;
                    $depth++;
                    continue;
                }
                while ($grand = $parent->getParentCategory()) {
                    if (in_array($grand, $categories)) {
                        $branch[$grand->getId()] = $category;
                        $category = $grand;
                        $depth++;
                        break;
                    }
                    $parent = $grand;
                }
                if (empty($grand)) {
                    break;
                }
            }
            $branch[0] = $category;
            if (count($trees) === 0) {
                $trees[0][0][0] = $category;
            }
            foreach ($trees as $treeKey => $root) {

                if (!in_array([$category], array_column($trees, 0))) {
                    $trees[][] = [$category];
                    continue;
                }

                if ([$category] !== $root[0]) {
                    continue;
                }
                if (empty(array_column($root, $depth))) {
                    $trees[$treeKey][$depth] = [];
                }
                foreach ($branch as $parentKey => $v) {
                    if ($parentKey === 0) {
                        continue;
                    }
                    if (empty($trees[$treeKey][$depth][$parentKey])) {
                        $trees[$treeKey][$depth][$parentKey] = [];
                    }

                    if (!in_array($v, $trees[$treeKey][$depth][$parentKey])) {
                        $trees[$treeKey][$depth][$parentKey][] = $v;

                    }
                    $depth--;
                }
            }
        }

        return $this->render('category/menu.html.twig', [
            'trees' => $trees,
        ]);
    }
}