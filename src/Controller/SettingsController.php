<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/accounts")
 */
class SettingsController extends AbstractController
{
    /**
     * @Route("/settings", name="account_settings")
     */
    public function index()
    {
        return $this->render('settings/index.html.twig', [
                
            ]);
    }
}
