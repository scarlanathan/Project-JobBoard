<?php

namespace App\Controller;

use App\Entity\Advertisements;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutusController extends AbstractController
{
    #[Route('/about_us', name: 'app_aboutus')]
    public function index(): Response
    {
        return $this->render('aboutus/index.html.twig', [
            'controller_name' => 'AboutusController',
        ]);
    }
}
