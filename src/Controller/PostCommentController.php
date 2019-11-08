<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostComment;
use App\Form\PostCommentType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostCommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;


/**
 * @Route("/post/comment")
 */
class PostCommentController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * The {id} param in route is the related post id for this new comment
     * 
     * @Route("/{id}/new", name="post_comment_new", methods={"GET","POST"})
     */
    public function new(Post $post, Request $request): Response
    {
        $comment = $request->request->get('post_comment_content');
        $user = $this->getUser();

        if ($comment && $post) {
            $postComment = new PostComment();
            
            $postComment
                        ->setContent($comment)
                        ->setAuthor($user)
                        ->setPost($post)
                        ;

            $this->em->persist($postComment);
            $this->em->flush();
        }

        return $this->redirectToRoute('post_show', [
            'id'    =>  $post->getId()  
        ]);
    
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
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
     * @Route("/{id}/remove/{_token}", name="comment_remove")
     * @Security("comment.isAuthor(user)")
     */
    public function remove(Request $request, PostComment $comment)
    {
        if ($comment instanceof PostComment) {
            $this->em->remove($comment);
            $this->em->flush();

            $this->addFlash('info', 'La publication a bien été suprimer!');
        }
        
        return $this->redirectToRoute('post_show', [
            'id'    =>  $comment->getPost()->getId()
        ]);
        
    }

    /**
     * @Route("/{id}/is_abuse", name="comment_is_abuse")
     */
    public function isAbuse(Request $request, PostComment $comment, FlashBagInterface $flashBag)
    {
        $flashBag->add('info', 'Vous avez signalé un contenu abusif.');

        return $this->redirectToRoute('post_show', [
            'id'    =>    $comment->getPost()->getId()
        ]);
    }
}
