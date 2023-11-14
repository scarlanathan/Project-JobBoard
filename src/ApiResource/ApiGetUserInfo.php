<?php

namespace App\ApiResource;

use App\Entity\User;
use App\Entity\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ApiGetUserInfo extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get_user(Security $security): JsonResponse
    {

        $user = $security->getUser();
        if (!empty($user)){
            $data = [
                "user_email" => $user->getUserIdentifier(),
                "user_role" => $user->getRoles(),
            ];
        }else{
            $data = [
                "user_email" => '',
            ];
        }

        return new JsonResponse($data);
    }

    public function get_user_profile(Security $security):JsonResponse
    {
        $user = $security->getUser();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email"=>$user->getUserIdentifier()]);
        $user_pofile = $this->entityManager->getRepository(UserProfile::class)->findOneBy(["user_id"=>$user->getId()]);
        if (isset($user_pofile)){
            $profile = true;
        }else{
            $profile = false;
            $user_pofile = new UserProfile();
            $user_pofile->setUserId($user);
            $user_pofile->setInfoUser("");
            $user_pofile->setLocation("");
            $user_pofile->setName("");
            $user_pofile->setCvPath("");
            $this->entityManager->persist($user_pofile);
            $this->entityManager->flush();
        }

        $data = [
            "username" => $user_pofile->getName(),
            "info_user" => $user_pofile->getInfoUser(),
            "cv_path" => $user_pofile->getCvPath(),
            "location" => $user_pofile->getLocation(),
            "profile" => $profile
        ];
        return new JsonResponse($data);
    }

    public function get_user_profilebyid(Request $request):JsonResponse
    {
        $id = $request->get("id");
        $user_pofile = $this->entityManager->getRepository(UserProfile::class)->findOneBy(["id"=>$id]);

        $data = [
            "username" => $user_pofile->getName(),
            "info_user" => $user_pofile->getInfoUser(),
            "cv_path" => $user_pofile->getCvPath(),
            "location" => $user_pofile->getLocation(),
        ];

        return new JsonResponse($data);
    }

    public function uploadCv(Request $request,Security $security):JsonResponse
    {
        $file = $request->files->get('file');

        if(!empty($file)){
            $file->move($this->getParameter('upload_dir'), $file->getClientOriginalName());
            $user = $security->getUser();
            $user_pofile = $this->entityManager->getRepository(UserProfile::class)->findOneBy(["user_id"=>$user->getId()]);
            $user_pofile->setCvPath($file->getClientOriginalName());
            $this->entityManager->persist($user_pofile);
            $this->entityManager->flush();
            $data = [
                "message" => $file->getClientOriginalName(),
            ];
        }else{
            $data = [
                "message" => false,
            ];
        }


        return new JsonResponse($data);
    }

    public function update_user_profile(Security $security,Request $request):JsonResponse
    {
        $user = $security->getUser();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email"=>$user->getUserIdentifier()]);
        $user_pofile = $this->entityManager->getRepository(UserProfile::class)->findOneBy(["user_id"=>$user->getId()]);


        $post_data = $request->getContent();
        $data = json_decode($post_data,true);
        $user_name = $data["user_name"];
        $location = $data["location"];
        $info_user = $data["info_user"];
        //$cv_path = $data["cv_path"];

        $user_pofile->setName($user_name);
        $user_pofile->setInfoUser($info_user);
        //$user_pofile->setCvPath($cv_path);
        $user_pofile->setLocation($location);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $data = [
            "user_name"=>$user_pofile->getName(),
            "location"=>$user_pofile->getLocation(),
            "info_user"=>$user_pofile->getInfoUser(),
            "cv_path"=>$user_pofile->getCvPath()
        ];

        return new JsonResponse($data);
    }
}