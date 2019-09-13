<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PostAttachement;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/accounts/posts")
 */
class PostController extends AbstractController
{

	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	/**
	 * @Route("/add", name="post_add", methods={"POST"})
	 */
	public function add(Request $request)
	{
		$user = $this->getUser();
		$postContent = $request->request->get('post_content');
		$postAttach = $request->files->get('post_attach');

		if ($postContent || $postAttach) {
			$post = new Post();

			if (null !== $postAttach) {
				$postAttachement = new PostAttachement();
				$postAttachement->file = $postAttach;
				$postAttach = $postAttachement;

            	$postAttach->upload();
			}

			$post
				->setContent($postContent)
				->setAttachement($postAttach)
				->setAuthor($user)
				;


			$this->em->persist($post);
			$this->em->flush();

			return $this->redirectToRoute('post_show', [
				'id'=>$post->getId()
			]);
		}
		
		return $this->redirectToRoute('home');
	}

	/**
	 * @Route("/{id}/show", name="post_show")
	 */
	public function show(Request $request, Post $post)
	{
		return $this->render('post/show.html.twig', [
            	'post' => $post
        	]);
	}

	/**
	 * @Route("/{id}/update", name="post_update")
	 */
	public function update(Request $request)
	{
		
	}

	/**
	 * @Route("/{id}/remove/{_token}", name="post_remove")
	 * @Security("post.isAuthor(user)")
	 */
	public function remove(Request $request, Post $post)
	{
		if ($post) {
			$this->em->remove($post);
			$this->em->flush();

			$this->addFlash('info', 'La publication a bien été suprimer!');
		}

		return $this->redirectToRoute('home');
	}

	/**
	 * @Route("/{id}/is_abuse", name="post_is_abuse")
	 */
	public function isAbuse(Request $request, Post $post)
	{
		
	}
}