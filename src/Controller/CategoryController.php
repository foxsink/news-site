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
        $categories = $repository->getCategoriesWithPosts();
        $trees = [];
        foreach ($categories as $category) {
            $branch = [];
            $depth = 0;
            while ($parent = $category->getParentCategory()) {
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
            if (count($trees) === 0) {
                $trees[0][0] = $category;
            }
            foreach ($trees as $treeKey => $root) {
                if (!in_array($category, array_column($trees, 0))) {
                    $trees[][] = $category;
                    continue;
                }
                foreach ($branch as $k => $v) {
                    if (!isset($root[$k])) {
                        $trees[$treeKey][$k] = ['depth' => $depth];
                    }
                    if (!in_array([$v], $trees[$treeKey][$k])) {
                        $trees[$treeKey][$k][] = [$v];
                    }
                }

            }
        }
//        dd($trees);
        return $this->render('category/menu.html.twig', [
            'trees' => $trees,
        ]);
    }

    private function isParent(Category $parent, Category $child): bool
    {
        $upper = $child->getParentCategory();
        if (!$upper) {
            return false;
        }
        if ($upper === $parent) {
            return true;
        } else {
            return $this->isParent($upper, $parent);
        }
    }

    /**
     * @param Category[] $categories
     */
    private function findUniqueBranchOfTree(iterable $categories = []): array
    {
        if (empty($categories)) {
            return [];
        }
        $platform = [];
        foreach ($categories as $category) {
            $children = $this->findUniqueBranchOfTree($category->getChildCategories());
            if (empty($children)) {
                $platform[] = $category;
                continue;
            }
            $platform[] = $children;
            $platform[] = $category;

        }
        return $platform;
    }
}