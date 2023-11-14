<?php

namespace App\ApiResource;

use App\Entity\JobCategories;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
#[AsController]
class ApiJobCategories extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find(Request $request): JsonResponse
    {
        $request_key = $request->get("key");

        $categories = $this->entityManager->getRepository(JobCategories::class);
        $res = $categories->findJobByKey($request_key);
        $data = [];
        foreach ($res as $r){
            $data[] = [
                "name" => $r->getName()
            ];
        }

        return new JsonResponse($data);

    }



}