<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\PlayerNotice;
use App\Form\PlayerNoticeType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayerNoticeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @Route("/player/notice")
 */
class PlayerNoticeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/{player_id}/new", name="player_notice_new", methods={"GET","POST"})
     * @ParamConverter("player", options={"mapping": {"player_id": "id"}})
     */
    public function new(Player $player, Request $request): Response
    {
        $notice = $request->request->get('player_notice_content');
        $user = $this->getUser();

        if ($notice && $player) {
            $playerNotice = new PlayerNotice;

            $playerNotice
                          ->setContent($notice)
                          ->setAuthor($user)
                          ->setPlayer($player)
                          ;

            $this->em->persist($playerNotice);
            $this->em->flush();
        }


        return $this->redirectToRoute('player', [
            'id'    =>  $player->getId(),
            'slug'  =>  $player->getSlug(),
        ]);
    }

    /**
     * @Route("/{player_id}/{author_id}/edit", name="player_notice_edit")
     * @ParamConverter("playerNotice", options={"mapping": {"player_id": "player", "author_id": "author"}})
     * @ParamConverter("player", options={"mapping": {"player_id": "id"}})
     */
    public function edit(Request $request, PlayerNotice $playerNotice, Player $player): Response
    {
        $noticeContent = $request->request->get('notice_content');

        if ($request->isMethod('post') && null != $noticeContent) {
            $playerNotice->setContent($noticeContent);

            $this->em->flush();

            return $this->redirectToRoute('player', [
                'id'    =>  $player->getId(),
                'slug'  =>  $player->getSlug(),
            ]);
        }

        return $this->render('player_notice/edit.html.twig', [
            'notice' =>  $playerNotice,
        ]);
    }

    /**
     * @Route("/{player_id}/{author_id}/delete", name="player_notice_delete")
     * @ParamConverter("playerNotice", options={"mapping": {"player_id": "player", "author_id": "author"}})
     * @ParamConverter("player", options={"mapping": {"player_id": "id"}})
     */
    public function delete(Request $request, Player $player, PlayerNotice $playerNotice, CsrfTokenManagerInterface $csrfTokenManagerInterface): Response
    {
        // if ($this->isCsrfTokenValid('delete'.$playerNotice->getAuthor()->getId(), $request->request->get('_token'))) {
        //     $this->em->remove($playerNotice);
        //     $this->em->flush();
        // }
        
        if (null === $player && null === $playerNotice) {
            throw $this->createNotFoundException();
        }

        $this->em->remove($playerNotice);
        $this->em->flush();

        return $this->redirectToRoute('player', [
            'id'    =>  $player->getId(),
            'slug'  =>  $player->getSlug(),
        ]);
    }

    /**
     * @Route("/{player_id}/{author_id}/lock", name="player_notice_lock")
     * @ParamConverter("playerNotice", options={"mapping": {"player_id": "player", "author_id": "author"}})
     * @ParamConverter("player", options={"mapping": {"player_id": "id"}})
     */
    public function lock(Request $request, PlayerNotice $playerNotice, Player $player): Response
    {
        $user = $this->getUser();
        
        if ($player->getPage()->isGranted($user, 'ADMIN')) {
            $playerNotice->setIsLocked(true);

            $this->em->flush();

            return $this->redirectToRoute('player', [
                'id'    =>  $player->getId(),
                'slug'  =>  $player->getSlug(),
            ]);
        }

        return $this->render('player_notice/edit.html.twig', [
            'notice' =>  $playerNotice,
        ]);
    }
}
