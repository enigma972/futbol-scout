<?php

namespace App\Controller;

use App\Entity\Like;
use App\Form\LikeType;
use App\Repository\LikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/accounts/posts")
 */
class LikeController extends AbstractController
{
    /**
     * @Route("/{id}/like", name="like_add", methods={"GET"})
     */
    public function add(Post $post, EntityManagerInterface $em, Request $request, $id, LikeRepository $likes)
    {
        $isAjax = $request->isXmlHttpRequest();
        $connectedUser = $this->getUser();
        $jsonResponse = null;

        if (null !== $connectedUser) {
            if ($post instanceOf Post) {
                $like = $likes->findOneByPostAndAuthor($post, $connectedUser);

                if (null === $like) {
                    $like = new Like();

                    $like
                        ->setAuthor($connectedUser)
                        ->setPost($post);

                    $em->persist($like);
                    $em->flush();

                    $jsonResponse = $this->json(['status' => 'postLiked']);
                }else{
                    $jsonResponse = $this->json(['status' => 'postIsLiked']);
                }
            }else{
                $jsonResponse = $this->json(['status' => 'error']);
            }
        }else{
            $jsonResponse = $this->json(['status' => 'error']);
        }

        if ($isAjax) return $jsonResponse;

        return $this->redirectToRoute('post_show', ['id' => $id]);
    }

    /**
     * @Route("/{id}/dislike", name="like_remove", methods={"GET"})
     */
    public function remove(Post $post, EntityManagerInterface $em)
    {


        $connectedUser = $this->getUser();

        if (null !== $connectedUser) {
            if ($post instanceOf Post) {
                $like = new Like();

                $like
                    ->setAuthor($connectedUser)
                    ->setPost($post);

                $em->persist($like);
                $em->flush();
            }
        }
    }
}
