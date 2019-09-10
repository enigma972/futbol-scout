<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PlayerRepository;
use App\Entity\Player;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PlayerDataFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Repository\UserRepository;


/**
 * @Route("/accounts")
 */
class PlayerController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/joueur/{slug}-{id}", name="player")
     */
    public function index(User $user, PlayerRepository $players, UserRepository $users)
    {
        if ($user instanceOf User) {
            $player = $players->findOneByUser($user);
        }

        $usersSuggest = $users->findByUserForSuggest($this->getUser());

        return $this->render('player/player_page.html.twig', [
            'player'    =>      $player,
            'usersSuggest' =>   $usersSuggest,
        ]);
    }

    /**
     * @Route("/complete/registration", name="complete_player_data")
     */
    public function completePlayerData(Request $request, PlayerRepository $playerRepot)
    {
    	$user = $this->getUser();

    	$player = $playerRepot->findOneByUser($user);
    	$form = $this->createForm(PlayerDataFormType::class, $player);
    	$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $user->getAvatar();
            $file = $form->get('file')->getData();

            $avatar->preUpload($file);

            $user->setIsComplete(true);
            
    		$this->em->flush();

            $avatar->upload();

            return $this->redirectToRoute('home');
    	}

    	return $this->render('player/complete_player_data.html.twig', [
    		'playerDataFormType'	=>	$form->createView()
    	]);
    }
}
