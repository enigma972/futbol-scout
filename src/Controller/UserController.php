<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlayerRepository;
use App\Entity\Player;
use App\Form\PlayerDataFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            
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
    		$em->flush();
            return $this->redirectToRoute('home');
    	}

    	return $this->render('user/complete_player_data.html.twig', [
    		'playerDataFormType'	=>	$form->createView()
    	]);
    }
}
