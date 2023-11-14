<?php

namespace App\ApiResource;

use App\Entity\User;
use App\Entity\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
#[AsController]
class ApiRegisterController extends AbstractController
{
    private $entityManager;
    private $userPasswordHasher;
    public function __construct(EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function register(Request $request): JsonResponse
    {
        $post_data = $request->getContent();
        $data = json_decode($post_data,true);
        $email = $data["email"];
        $password = $data["password"];
        $password_confirm = $data["password_confirm"];
        $is_rh = $data["is_hr"];
        $isUserExists = $this->check_user($email);
        $role = ["ROLE_USER"];
        if (!$isUserExists){
            if (filter_var($email,FILTER_VALIDATE_EMAIL)){
                if ($password === $password_confirm){
                    $user = new User();
                    $user->setEmail($email);
                    $user->setPassword(
                        $this->userPasswordHasher->hashPassword(
                            $user,
                            $password
                        )
                    );
                    if ($is_rh){
                        array_push($role,"ROLE_COMPAINE");
                    }
                    $user->setRoles($role);
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();

                    $data = [
                        "message" => "success",
                        "user_email" => $email
                    ];



                    $res = new JsonResponse($data);
                    $res->setStatusCode(200);
                }else{
                    $res = $this->error_message(["message" => "Please reconfirm password !"],400);
                }
            }else{
                $res = $this->error_message(["message" => "Error email format !"],400);
            }
        }else{
            $res = $this->error_message(["message" => "User Exist !"],400);
        }

        return $res;
    }

    private function check_user($email):bool
    {
        $user = $this->entityManager->getRepository(User::class)->findBy(["email"=>$email]);

        return !empty($user);
    }

    private function error_message($error_message,$http_code):JsonResponse
    {
        $res = new JsonResponse($error_message);
        $res->setStatusCode($http_code);
        return $res;
    }

}