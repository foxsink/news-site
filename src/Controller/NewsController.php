<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends AbstractController
{
    public function indexAction(): Response
    {
        return $this->render('news/index.html.twig');
    }

    public function showAction(): Response
    {
        return $this->render('news/index.html.twig');
    }
}