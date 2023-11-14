<?php

namespace App\ApiResource;


use ApiPlatform\Metadata\ApiResource;
use App\Entity\Advertisements;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[ApiResource]
class ApiRecherches extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get_job(Request $request):JsonResponse
    {
        $key = $request->get("key");
        $advertisements = $this->entityManager->getRepository(Advertisements::class);
        $res = $advertisements->get_job_byNameAndCategory($key);
        $data = [];
        foreach ($res as $r){
            $ca = [];
            $categories = $r->getJobCategoriesId();
            foreach ($categories as $category){
                $ca[] = $category->getName();
            }
            $data[] = [
                "id"=>$r->getId(),
                "type_contrat"=>$r->getTypeContrat(),
                "public_date"=>$r->getPublicDate()->format("Y-m-d"),
                "salary"=>$r->getSalary(),
                "job_name"=>$r->getNameJob(),
                "description"=>$r->getDescription(),
                "categories"=>$ca,
            ];
        }

        return new JsonResponse($data);
    }

    public function get_jobById(Request $request):JsonResponse
    {
        $key = $request->get("id");
        $advertisements = $this->entityManager->getRepository(Advertisements::class)->findOneBy(["id"=>$key]);

        $data = [
            "id"=>$advertisements->getId(),
            "type_contrat"=>$advertisements->getTypeContrat(),
            "public_date"=>$advertisements->getPublicDate()->format("Y-m-d"),
            "salary"=>$advertisements->getSalary(),
            "job_name"=>$advertisements->getNameJob(),
            "description"=>$advertisements->getDescription(),
            "start_date"=>$advertisements->getStartDate()->format("Y-m-d"),
            "end_date"=>$advertisements->getEndDate()->format("Y-m-d"),
            "type_job"=>$advertisements->getTypeJob(),
            "work_time"=>$advertisements->getWorkTime(),
            "companie_name"=>$advertisements->getCompanieId()->getCompaniesProfile()->getName(),
            "companie_location"=>$advertisements->getCompanieId()->getCompaniesProfile()->getLocation(),
            "info_companie"=>$advertisements->getCompanieId()->getCompaniesProfile()->getInfoCompanie(),
            "phone_companie"=>$advertisements->getCompanieId()->getCompaniesProfile()->getPhone(),
            "email_companie"=>$advertisements->getCompanieId()->getUserIdentifier()
        ];

        return new JsonResponse($data);
    }

}