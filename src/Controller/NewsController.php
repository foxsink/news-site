<?php


namespace App\Controller;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function indexAction(PostRepository $repository, ?int $page = null): Response
    {
        $page = $page ?? 0;
        $paginator = $repository->getPostsPagination($page);

        return $this->render('news/index.html.twig', [
            'paginator'  => $paginator,
            'pageCount'  => count($paginator),
            'pageNumber' => $page,
        ]);
    }

    public function showAction(): Response
    {
        return $this->render('news/index.html.twig');
    }
}