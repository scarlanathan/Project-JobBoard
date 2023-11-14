<?php

namespace App\Controller;

use App\Entity\Advertisements;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
        ]);
    }
}
