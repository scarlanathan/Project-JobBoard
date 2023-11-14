<?php

namespace App\ApiResource;

use App\Entity\CompanieCategories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ApiCompanieCategorie extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get_categorie(Request $request): JsonResponse
    {
        $categorie = $this->entityManager->getRepository(CompanieCategories::class);
        $res = $categorie->findAll();
        $data = [];

        foreach ($res as $r){
            $data[] = ["id" => $r->getId(), "name" => $r->getName()];
        }

        return new JsonResponse($data);
    }
}