<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/articles', name: 'app_articles')]
    public function allarticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('index/articles.html.twig', [
            'articles' => $articles,
        ]);
    }
}
