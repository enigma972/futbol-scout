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

class UserController extends AbstractController
{
    /**
     * @Route("/user/{slug}-{id}", name="user_profil")
     */
    public function profil(User $user)
    {
        return $this->render('user/profil.html.twig', [
            'user'  =>  $user
        ]);
    }

    /**
     * @Route("/user/complete/registration", name="complete_player_data")
     */
    public function completePlayerData(Request $request, PlayerRepository $playerRepot, EntityManagerInterface $em)
    {
    	$user = $this->getUser();

    	$player = $playerRepot->findOneByUser($user);
    	$form = $this->createForm(PlayerDataFormType::class, $player);
    	$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsComplete(true);
    		$em->flush();
            return $this->redirectToRoute('home');
    	}

    	return $this->render('user/complete_player_data.html.twig', [
    		'playerDataFormType'	=>	$form->createView()
    	]);
    }
}
