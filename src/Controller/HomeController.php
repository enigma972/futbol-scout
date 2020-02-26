<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, AuthorizationCheckerInterface $authChecker, PostRepository $posts)
    {
        $page = $request->query->get('page');
        //$nbParPage = $request->query->get('nbParPage');


        if (!is_int($page) && $page < 1)  $page = 1;

        /**
         * @var connectedUser $connectedUser the current user
         */
        $connectedUser = $this->getUser();

    	if (null != $connectedUser) {
            $follows = $connectedUser->getFollows();
            $posts = $posts->findByFollows($connectedUser, $follows, $page);

    		return $this->render('home/flux.html.twig', [
            	'posts' => $posts,
                'page'         =>   $page+1,
                'nbParPage'    =>   ceil(count($posts)/10),
        	]);
    	}

    	return $this->render('home/index.html.twig', [
            
        ]);
    }
}
