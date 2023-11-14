<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatesController extends AbstractController
{
    #[Route('/candidates', name: 'app_candidates')]
    public function index(): Response
    {
        return $this->render('candidates/index.html.twig', [
            'controller_name' => 'CandidatesController',
        ]);
    }
}
