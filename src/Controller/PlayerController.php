<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\PlayerPage;
use App\Entity\PlayerPromoClip;
use App\Form\PlayerDataFormType;
use App\Entity\PlayerPageManager;
use App\Repository\UserRepository;
use App\Repository\PlayerRepository;
use App\Entity\PlayerPicture as Picture;
use App\Entity\PlayerSearch;
use App\Form\PlayerSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/player/page/create", name="create_player")
     */
    public function create(Request $request)
    {
        $user = $this->getUser();

        $player = new Player;

        $form = $this->createForm(PlayerDataFormType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // Create the first manager with ADMIN default role
            $manager = new PlayerPageManager;

            $manager->setRoles(['ADMIN']);
            $manager->setUser($user);

            // Create the page related to this player and add the ADMIN manager
            $page = new PlayerPage;
            
            $page->addManager($manager);
            $page->setPlayer($player);


            // set player picture
            $file = $request->request->get('file');

            $picture = new Picture();
            $picture->preUpload($file);
            $player->setPicture($picture);

            
            $this->em->persist($manager);
            $this->em->persist($page);
            $this->em->persist($player);
            $this->em->flush();

            $picture->upload();

            return $this->redirectToRoute('player', [
                'id'    =>  $player->getId(),
                'slug'  => $player->getSlug(),
            ]);
        }

        return $this->render('player/create_player.html.twig', [
            'playerDataFormType'    =>    $form->createView()
        ]);
    }

    /**
     * @Route("/joueur/{slug}-{id}", name="player")
     */
    public function index(Player $player, UserRepository $users)
    {
        if (!$player) {
            throw $this->createNotFoundException("Le joueur que vous cherchez n'existe pas !");
        }
        if ($player instanceOf Player) {
            
            $usersSuggest = $users->findByUserForSuggest($this->getUser());

            return $this->render('player/player_page.html.twig', [
                'player'    =>      $player,
                'usersSuggest' =>   $usersSuggest,
            ]);
        }
    }

    /**
     * @Route("/joueur/{id}/follow", name="player_follow")
     */
    public function follow(Player $player)
    {
        $connectedUser = $this->getUser();

        if($player) {
            $player->addFan($connectedUser);
            $this->em->flush();
        }

        return $this->redirectToRoute('player', [
            'id'    =>  $connectedUser->getId(),
            'slug'  =>  $connectedUser->getSlug(),
            ]);
    }

    /**
     * @Route("/joueur/{id}/disfollow", name="player_disfollow")
     */
    public function disfollow(Player $player)
    {
        $connectedUser = $this->getUser();

        if($player) {
            $player->removeFan($connectedUser);
            $this->em->flush();
        }

        return $this->redirectToRoute('player', [
            'id'    =>  $connectedUser->getId(),
            'slug'  =>  $connectedUser->getSlug(),
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

    /**
     * @Route("/joueur/{id}/ajouter/clip-de-promo", name="add_promo_clip")
     * @Security("player.getPage().isGranted(user, 'ADMIN')")
     */
    public function addPromoClip(Player $player, Request $request)
    {
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $file = $request->files->get('promo_clip');
            if ($file) {
                $promoClip = new PlayerPromoClip();
                $promoClip->preUpload($file);

                if ($promoClip->getSize() <= 70) {
                        $player->setPromoClip($promoClip);

                        $this->em->flush();
                        $promoClip->upload();
                        
                        return $this->redirectToRoute('player', [
                            'id'    =>  $user->getId(),
                            'slug'  =>  $user->getSlug(),
                        ]);
                }
                
            }
            
        }

        return $this->render('player/add_promo_clip.html.twig', [
            'player'    =>  $player,
        ]);
    }

    /**
     * @Route("/joueur/{id}/modifier/clip-de-promo", name="update_promo_clip")
     * @Security("player.getPage().isGranted(user, 'ADMIN')")
     */
    public function updatePromoClip(Request $request, Player $player)
    {
        $user = $this->getUser();

        if ($request->isMethod('post')) {
            $file = $request->files->get('promo_clip');

            if ($file) {
                    $promoClip = $player->getPromoClip();

                    if (null === $promoClip) {
                        $promoClip = new PlayerPromoClip();
                        $player->setPromoClip($promoClip);                 
                    }
                    
                    $promoClip->preUpload($file);

                    $this->em->flush();
                    $promoClip->upload();

                    return $this->redirectToRoute('player', [
                        'id'    =>  $user->getId(),
                        'slug'  =>  $user->getSlug(),
                    ]);
            }
        }

        return $this->render('player/update_promo_clip.html.twig');
    }

    /**
     * @Route("/trouver-un-joueur", name="search_player")
     */
    public function search(Request $request, PlayerRepository $playerRepository)
    {
        $page = (int) $request->query->get('page');

        if ($page < 1)  { $page = 1; }

        $playerSearch = new PlayerSearch;
        $form = $this->createForm(PlayerSearchType::class, $playerSearch);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $players = $playerRepository->findAllByQuery($form->getData(), $page);
        }else {
            $players = $playerRepository->findAll();
        }

        return $this->render('player/search_player.html.twig',[
            'searchForm'    =>  $form->createView(),
            'players'       =>  $players,
            'page'          =>  $page + 1,
            'nbParPage'     =>  ceil(count($players) / 12),
        ]);
    }
}
