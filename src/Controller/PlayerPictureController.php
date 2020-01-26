<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/accounts")
 */
class PlayerPictureController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }
    /**
     * @Route("/joueur/{id}/picture/change", name="player_change_picture", methods={"GET", "POST"})
     * @Security("player.getPage().isGranted(user, 'ADMIN')")
     */
    public function changePicture(Player $player, Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $picture = $player->getPicture();
            $file = $request->files->get('avatar');
            $picture->preUpload($file);

            if (!null == $picture->file()) {
                $this->em->flush();

                $picture->upload();

                return $this->redirectToRoute('player', [
                    'id'    =>  $player->getId(),
                    'slug'  =>  $player->getSlug(),
                ]);
            }
        }
        return $this->render('player/change_picture.html.twig', [
            'player'    =>  $player
        ]);
    }
}
