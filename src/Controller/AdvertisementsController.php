<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertisementsController extends AbstractController
{
    #[Route('/advertisements', name: 'app_advertisements')]
    public function index(): Response
    {
        return $this->render('advertisements/index.html.twig', [
            'controller_name' => 'AdvertisementsController',
        ]);
    }
}
