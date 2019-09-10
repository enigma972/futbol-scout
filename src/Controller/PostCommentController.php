<?php

namespace App\Controller;

use App\Entity\PostComment;
use App\Form\PostCommentType;
use App\Repository\PostCommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post/comment")
 */
class PostCommentController extends AbstractController
{
    /**
     * @Route("/new", name="post_comment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $postComment = new PostComment();
        $form = $this->createForm(PostCommentType::class, $postComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($postComment);
            $entityManager->flush();

            return $this->redirectToRoute('post_comment_index');
        }

        return $this->render('post_comment/new.html.twig', [
            'post_comment' => $postComment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PostComment $postComment): Response
    {
        $form = $this->createForm(PostCommentType::class, $postComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_comment_index');
        }

        return $this->render('post_comment/edit.html.twig', [
            'post_comment' => $postComment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_comment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PostComment $postComment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postComment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($postComment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_comment_index');
    }
}
