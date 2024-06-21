<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{

    #[Route('/comment/{id}/comment/add', name: 'comment_add', methods: ['POST'])]
    public function addComment(Request $request, comment $comment, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();
       
            return $this->redirectToRoute('app_comment_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment_crud/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }
}
