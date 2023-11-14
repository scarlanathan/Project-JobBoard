<?php

namespace App\ApiResource;

use App\Entity\CompanieCategories;
use App\Entity\CompaniesProfile;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ApiGetCompaniesInfo extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function get_Companie_profile(Security $security)
    {
        $user = $security->getUser();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email"=>$user->getUserIdentifier()]);
        $companie_pofile = $this->entityManager->getRepository(CompaniesProfile::class)->findOneBy(["user_id"=>$user->getId()]);

        if (isset($companie_pofile)){
            $profile = true;
        }else{
            $profile = false;
            $companie_pofile = new CompaniesProfile();
            $companie_pofile->setUserId($user);
            $companie_pofile->setName("");
            $companie_pofile->setLocation("");
            $companie_pofile->setInfoCompanie("");
            $companie_pofile->setPhone("");
            $companie_pofile->setCategorieId(null);

            $this->entityManager->persist($companie_pofile);
            $this->entityManager->flush();
        }

        $data = [
            "username" => $companie_pofile->getName(),
            "info_companie" => $companie_pofile->getInfoCompanie(),
            "phone" => $companie_pofile->getPhone(),
            "location" => $companie_pofile->getLocation(),
            "categories" => $companie_pofile->getCategorieId()->getId(),
            "profile" => $profile
        ];

        return new JsonResponse($data);

    }

    public function update_companie_profile(Security $security,Request $request):JsonResponse
    {
        $user = $security->getUser();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email"=>$user->getUserIdentifier()]);
        $companie_pofile = $this->entityManager->getRepository(CompaniesProfile::class)->findOneBy(["user_id"=>$user->getId()]);

        $post_data = $request->getContent();
        $data = json_decode($post_data,true);
        $user_name = $data["user_name"];
        $location = $data["location"];
        $info_companie = $data["info_companie"];
        $phone = $data["phone"];
        $categorie_id = $data["categories"];
        $categorie_entity = $this->entityManager->getRepository(CompanieCategories::class)->findOneBy(["id"=>$categorie_id]);

        $companie_pofile->setName($user_name);
        $companie_pofile->setInfoCompanie($info_companie);
        $companie_pofile->setPhone($phone);
        $companie_pofile->setLocation($location);
        $companie_pofile->setCategorieId($categorie_entity);

        $this->entityManager->persist($companie_pofile);
        $this->entityManager->flush();

        $data = [
            "username"=>$companie_pofile->getName(),
            "info_companie"=>$companie_pofile->getInfoCompanie(),
            "location"=>$companie_pofile->getLocation(),
            "phone"=>$companie_pofile->getPhone(),
            "categories"=>$companie_pofile->getCategorieId()->getId(),
        ];

        return new JsonResponse($data);
    }
}
