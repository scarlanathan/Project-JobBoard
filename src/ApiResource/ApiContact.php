<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[ApiResource]
class ApiContact extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function send_content(Request $request):JsonResponse
    {
        $request_data = $request->getContent();
        $data = json_decode($request_data,true);
        $email = $data["email"];
        $username = $data["username"];
        $content = $data["content"];
        if (!empty($email) && !empty($username) && !empty($content)){
            $contact = new Contact();

            $contact->setEmail($email);
            $contact->setUsername($username);
            $contact->setContent($content);

            $this->entityManager->persist($contact);
            $this->entityManager->flush();
        }

        $data = [
            "message" => true
        ];

        return new JsonResponse($data);
    }
}