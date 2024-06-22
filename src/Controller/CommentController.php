<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/{id}', name: 'comment_index', methods: ['GET'])]
    public function index(CommentRepository $comments): Response
    {
        $comments = $comments->findAll();

        return $this->render(
            'comment/index.html.twig', 
            ['comments' => $comments]);
    }

    #[Route('/comment/{id}/add', name: 'comment_add', methods: ['GET', 'POST'])]
    public function addComment(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        
        $comment = new Comment();
        $comment->setArticles($article);//preremplir larticle ppour id
        $comment->setCreatedAt(new \DateTime());

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_articles', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
