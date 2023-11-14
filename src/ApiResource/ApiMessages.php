<?php

namespace App\ApiResource;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ApiMessages extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get_messages(Security $security):JsonResponse
    {
        $user_email = $security->getUser()->getUserIdentifier();
        $is_companie = $this->isGranted("ROLE_COMPAINE");

        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email"=>$user_email]);
        if($is_companie){
            $messages = $this->entityManager->getRepository(Message::class)->findBy(["companie_id"=>$user,"companie_delete"=>0]);
        }else{
            $messages = $this->entityManager->getRepository(Message::class)->findBy(["user_id"=>$user,"user_delete"=>0]);
        }



        $data = [];
        foreach ($messages as $message){
            $data[] = [
                "id" => $message->getId(),
                "user" => $message->getUserId()->getUserIdentifier(),
                "companie" => $message->getCompanieId()->getUserIdentifier(),
                "objet" => $message->getObj(),
                "content" => $message->getContent(),
                "date"=>$message->getSendDate(),
                "type_sender"=>$message->isSendType(), // if false sender = user else = companies
                "is_delete_user"=>$message->isUserDelete(),
                "is_delete_companie"=>$message->isCompanieDelete(),
            ];
        }

        return new JsonResponse($data);
    }

    public function get_messageById(Request $request,Security $security):JsonResponse
    {
        $message = $this->entityManager->getRepository(Message::class)->findOneBy(["id"=>$request->get('id')]);
        $data = [
            "user" => $message->getUserId()->getUserIdentifier(),
            "companie" => $message->getCompanieId()->getUserIdentifier(),
            "objet" => $message->getObj(),
            "content" => $message->getContent(),
            "date"=>$message->getSendDate()->format("Y-m-d"),
        ];
        return new JsonResponse($data);
    }

    public function send_message(Request $request,Security $security):JsonResponse
    {
        $request_data = $request->getContent();
        $data = json_decode($request_data,true);

        $email = $data["email"];
        $content = $data["content"];
        $obj = $data["objet"];

        $user_email = $security->getUser()->getUserIdentifier();

        $is_companie = $this->isGranted("ROLE_COMPAINE");

        $message = new Message();
        $message->setContent($content);
        $message->setObj($obj);
        $message->setSendDate(new \DateTime('now'));
        $message->setUserDelete(false);
        $message->setCompanieDelete(false);
        if ($is_companie){
            $user = $this->entityManager->getRepository(User::class)->findOneBy(["email"=>$user_email]);
            $message->setCompanieId($user);
            $message->setUserId($this->entityManager->getRepository(User::class)->findOneBy(["email"=>$email]));
            $message->setSendType(true);
        }else{
            $user = $this->entityManager->getRepository(User::class)->findOneBy(["email"=>$user_email]);
            $message->setUserId($user);
            $message->setSendType(false);
            $message->setCompanieId($this->entityManager->getRepository(User::class)->findOneBy(["email"=>$email]));
        }

        $this->entityManager->persist($message);
        $this->entityManager->flush();


        $data = [
            "message" => 'true'
        ];

        return new JsonResponse($data);
    }
    public function delete_message(Request $request,Security $security):JsonResponse
    {
        $user = $security->getUser()->getRoles();

        $post_data = $request->getContent();
        $data = json_decode($post_data,true);
        $is_companie = $this->isGranted("ROLE_COMPAINE");

        $message_id = $data["message_id"];
        $message = $this->entityManager->getRepository(Message::class)->findOneBy(['id'=>$message_id]);

        if ($is_companie){
            $message ->setCompanieDelete(1);
        }else{
            $message ->setUserDelete(1);
        }
        if ($message->isUserDelete() == 1 && $message->isCompanieDelete() == 1){
            $this->entityManager->remove($message);
            $this->entityManager->flush();
            $data = [
                "message" =>true
            ];
            return new JsonResponse($data);
        }
        $this->entityManager->persist($message);
        $this->entityManager->flush();
        $data = [
            "message" =>true
        ];
        return new JsonResponse($data);
    }
}