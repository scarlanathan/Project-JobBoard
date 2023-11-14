<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
;

use App\Entity\Advertisements;
use App\Entity\CandidateAnonymous;
use App\Entity\User;
use App\Entity\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[ApiResource]
class ApiCandidatesCompanies extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function get_candidates_user(Security $security):JsonResponse
    {
        $user_email = $security->getUser()->getUserIdentifier();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email"=>$user_email]);
        $ads = $this->entityManager->getRepository(Advertisements::class)->findBy(["companie_id"=>$user]);
        $data = [];
        foreach ($ads as $ad){
            $candidate_array = [];
            foreach ($ad->getUserCandidate() as $candidate){
                $profile_id = $candidate->getId();
                $user_id = $candidate->getUserId();
                $candidate_array[] = [
                    "profile_id" => $profile_id,
                    "email"=>$this->entityManager->getRepository(User::class)->findOneBy(["id"=>$user_id])->getUserIdentifier()
                ];
            }

            $candidate_array_anonymous = [];
            foreach ($ad->getCanditateAnonymous() as $candidate){
                $candidate_array_anonymous[] = [
                    "profile_id" => $candidate->getId(),
                    "email"=> $candidate->getEmail()
                ];
            }
            $data[] = [
                "ad_name" => $ad->getNameJob(),
                "user_profile" => $candidate_array,
                "user_anonymous" => $candidate_array_anonymous,
            ];
        }

        return new JsonResponse($data);
    }

    public function get_profile_anonymous(Request $request): Response
    {
        $id = $request->get("id");
        $profile_anonymous = $this->entityManager->getRepository(CandidateAnonymous::class)->findOneBy(["id" => $id]);

        $email = $profile_anonymous->getEmail();
        $content = $profile_anonymous->getContent();
        $phone = $profile_anonymous->getPhone();
        $lm = $profile_anonymous->getLm();

        $jsonData = [
            "email" => $email,
            "content" => $content,
            "phone" => $phone,
            "lm" => $lm,
        ];



        return new JsonResponse($jsonData);
    }

    public function get_cv_anonymous(Request $request): Response
    {
        $id = $request->get("id");
        $profile_anonymous = $this->entityManager->getRepository(CandidateAnonymous::class)->findOneBy(["id" => $id]);

        $cv = $profile_anonymous->getCv();
        $cvContent = stream_get_contents($cv);
        $response = new Response($cvContent);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}