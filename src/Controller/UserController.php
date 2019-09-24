<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlayerRepository;
use App\Entity\Player;
use App\Form\PlayerDataFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;


/**
 * @Route("/accounts/user")
 */
class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/{slug}-{id}", name="user_profil")
     */
    public function profil(PostRepository $posts, User $user, UserRepository $users)
    {
        if (null !== $user) {
            $posts = $posts->findByAuthor($user, ['postedAt' => 'DESC']);
            $usersSuggest = $users->findByUserForSuggest($user);

            return $this->render('user/profil.html.twig', [
                'posts'        => $posts,
                'user'         => $user,
                'usersSuggest' =>   $usersSuggest,
            ]);
        }
    }

    /**
     * @Route("/avatar/change", name="user_change_avatar", methods={"GET", "POST"})
     */
    public function changeAvatar(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $user = $this->getUser();
            $avatar = $user->getAvatar();
            $file = $request->files->get('avatar');
            $avatar->preUpload($file);

            if (!null == $avatar->file()) {
                $this->em->flush();

                $avatar->upload();

                return $this->redirectToRoute('user_profil',[
                    'slug'  =>  $user->getSlug(),
                    'id'    =>  $user->getId()
                ]);
            }

        }
        return $this->render('user/change_avatar.html.twig');
    }

    /**
     * @Route("/{id}/follow", name="user_follow")
     */
    public function follow(User $user)
    {
        /**
         * @var connectedUser $connectedUser the current user
         */
        $connectedUser = $this->getUser();
        
        if (null !== $user and $connectedUser != $user) {
            $connectedUser->addFollow($user);
            
            $this->em->flush();
        }

        return $this->redirectToRoute('user_profil', [
            'id'    =>     $user->getId(),
            'slug'  =>     $user->getSlug()
        ]);
    }

    /**
     * @Route("/{id}/disfollow", name="user_disfollow")
     */
    public function disFollow(User $user)
    {
        /**
         * @var connectedUser $connectedUser the current user
         */
        $connectedUser = $this->getUser();
        
        if (null !== $user and $connectedUser != $user) {
            $connectedUser->removeFollow($user);
            
            $this->em->flush();
        }

        return $this->redirectToRoute('user_profil', [
            'id'    =>     $user->getId(),
            'slug'  =>     $user->getSlug()
        ]);
    }
}
