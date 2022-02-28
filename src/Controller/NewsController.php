<?php


namespace App\Controller;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends AbstractController
{
    const COUNT_POSTS_ON_PAGE = 3;
    /**
     * @throws \Exception
     */
    public function indexAction(PostRepository $repository, Request $request, int $page = 1): Response
    {
        $queryOrder = $request->query->get('order');
        $order = in_array($queryOrder, PostRepository::POST_ORDER_ARRAY) ? $queryOrder : PostRepository::POST_ORDER_ASC;
        $paginator = $repository->getPostsPagination($page - 1, self::COUNT_POSTS_ON_PAGE, $order);
        return $this->render('news/index.html.twig', [
            'paginator'  => $paginator,
            'pageCount'  => $paginator->count()/self::COUNT_POSTS_ON_PAGE,
            'pageNumber' => $page,
            'order'      => $order,
        ]);
    }

    public function showAction(): Response
    {
        return $this->render('news/index.html.twig');
    }
}