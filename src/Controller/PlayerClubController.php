<?php

namespace App\Controller;

use App\Entity\PlayerClub as Club;
use App\Form\PlayerClubType;
use App\Repository\PlayerClubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/player/club")
 */
class PlayerClubController extends AbstractController
{
    /**
     * @Route("/store", name="player_club_store", methods={"GET","POST"})
     */
    public function store(Request $request, PlayerClubRepository $clubs, FlashBagInterface $flashBag): Response
    {
        $club = new Club();
        $form = $this->createForm(PlayerClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            if ($clubs->notExist($club)) {
                $entityManager->persist($club);
                $entityManager->flush();

                $errror = 0;
            }else {
                $error = 1;
            }
            
            if ($request->isXmlHttpRequest()) {
                return  new JsonResponse([
                    'error'     =>  $error,
                    'message'   =>  '',
                    'data'      =>  ['club'  =>  $club],
                ]);
            }

            $flashBag->set('warning', 'Ce club est déjà présent dans la liste !');
            
            return $this->redirectToRoute('create_player');
        }

        return $this->render('player_club/_form.html.twig', [
            'player_club' => $club,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="player_club_index", methods={"GET"})
     */
    public function index(PlayerClubRepository $playerClubRepository): Response
    {
        return $this->render('player_club/index.html.twig', [
            'player_clubs' => $playerClubRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="player_club_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $club = new Club();
        $form = $this->createForm(PlayerClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('player_club_index');
        }

        return $this->render('player_club/new.html.twig', [
            'player_club' => $club,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_club_show", methods={"GET"})
     */
    public function show(Club $club): Response
    {
        return $this->render('player_club/show.html.twig', [
            'player_club' => $club,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="player_club_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Club $club): Response
    {
        $form = $this->createForm(PlayerClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_club_index');
        }

        return $this->render('player_club/edit.html.twig', [
            'player_club' => $club,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_club_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Club $club): Response
    {
        if ($this->isCsrfTokenValid('delete'.$club->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($club);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_club_index');
    }
}
