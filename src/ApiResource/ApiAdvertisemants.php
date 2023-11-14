<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Advertisements;
use App\Entity\CandidateAnonymous;
use App\Entity\JobCategories;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[ApiResource]
class ApiAdvertisemants extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function get_ad(Security $security):JsonResponse
    {
        $user = $security->getUser();
        $ads = $this->entityManager->getRepository(Advertisements::class)->findBy(["companie_id"=>$user]);
        $data = [];
        foreach ($ads as $a){
            $data[] = [
                "id"=>$a->getId(),
                "description"=>$a->getDescription(),
                "name_job"=>$a->getNameJob(),
                "public_date"=>$a->getPublicDate()->format("Y-m-d"),
                "type_contrat"=>$a->getTypeContrat(),
            ];
        }

        return new JsonResponse($data);
    }

    public function get_ad_byname(Request $request):JsonResponse
    {
        $name = $request->get("key");
        $ad = $this->entityManager->getRepository(Advertisements::class)->get_job_byNameAndCategory($name);

        $data = [];
        foreach ($ad as $a){
            $data[] = [
                "name_job"=>$a->getNameJob(),
            ];
        }

        return new JsonResponse($data);
    }

    public function get_ad_byid(Request $request):JsonResponse
    {
        $id = $request->get("id");
        $ad = $this->entityManager->getRepository(Advertisements::class)->findOneBy(["id"=>$id]);
        $job_categorys = $ad->getJobCategoriesId();
        $category_array = [];
        foreach ($job_categorys as $category){
            $category_array[] = [
                "name" => $category->getName(),
                "id"=> $category->getId(),
            ];
        }
        $date = [
            "id"=>$ad->getId(),
            "description"=>$ad->getDescription(),
            "start_date"=>$ad->getStartDate()->format("Y-m-d"),
            "end_date"=>$ad->getEndDate()->format("Y-m-d"),
            "type_contrat"=>$ad->getTypeContrat(),
            "type_job"=>$ad->getTypeJob(),
            "salary"=>$ad->getSalary(),
            "work_time"=>$ad->getWorkTime(),
            "public_date"=>$ad->getPublicDate()->format("Y-m-d"),
            "name_job"=>$ad->getNameJob(),
            "categories" => $category_array
        ];
        return new JsonResponse($date);
    }
    public function create_ad(Security $security,Request $request):JsonResponse
    {
        $user = $security->getUser();

        $post_data = $request->getContent();
        $data = json_decode($post_data,true);
        $start_date = $data["start_date"];
        $end_date = $data["end_date"];
        $type_contrat = $data["type_contrat"];
        $type_job = $data["type_job"];
        $salary = $data["salary"];
        $work_time = $data["work_time"];
        $description = $data["description"];
        $job_name = $data["job_name"];
        $categorie = $data["categorie"];

        $categorie_entity = $this->entityManager->getRepository(JobCategories::class)->findOneBy(["name"=>$categorie]);

        $ad = new Advertisements();
        $ad->setCompanieId($user);
        $ad->setDescription($description);
        $ad->setStartDate(new \DateTime($start_date));
        $ad->setEndDate(new \DateTime($end_date));
        $ad->setSalary($salary);
        $ad->setTypeContrat($type_contrat);
        $ad->setTypeJob($type_job);
        $ad->setWorkTime($work_time);
        $ad->setPublicDate(new \DateTime('now'));
        $ad->setNameJob($job_name);
        $ad->addJobCategoriesId($categorie_entity);


        $this->entityManager->persist($ad);
        $this->entityManager->flush();

        $data = [
            "message" => true
        ];

        return new JsonResponse($data);
    }

    public function update_ad(Request $request,Security $security){
        $post_data = $request->getContent();
        $data = json_decode($post_data,true);
        $id = $data["ad_id"];
        $start_date = $data["start_date"];
        $start_date = new \DateTime($start_date);
        $end_date = $data["end_date"];
        $end_date = new \DateTime($end_date);
        $type_contrat = $data["type_contrat"];
        $type_job = $data["type_job"];
        $salary = $data["salary"];
        $work_time = $data["work_time"];
        $description = $data["description"];
        $job_name = $data["job_name"];

        $ad = $this->entityManager->getRepository(Advertisements::class)->findOneBy(["id"=>$id]);
        $ad->setNameJob($job_name);
        $ad->setWorkTime($work_time);
        $ad->setSalary($salary);
        $ad->setTypeJob($type_job);
        $ad->setStartDate($start_date);
        $ad->setEndDate($end_date);
        $ad->setTypeContrat($type_contrat);
        $ad->setDescription($description);

        $this->entityManager->persist($ad);
        $this->entityManager->flush();

        $data = [
            "message" => true
        ];

        return new JsonResponse($data);
    }

    public function delete_ad(Request $request):JsonResponse
    {
        $post_data = $request->getContent();
        $data = json_decode($post_data,true);
        $id = $data["ad_id"];

        $ad = $this->entityManager->getRepository(Advertisements::class)->findOneBy(['id'=>$id]);
        $this->entityManager->remove($ad);
        $this->entityManager->flush();

        $data = [
            "message" => true
        ];

        return new JsonResponse($data);
    }

    public function delete_job_category(Request $request):JsonResponse
    {
        $post_data = $request->getContent();
        $data = json_decode($post_data,true);

        $ad_id = $data["ad_id"];
        $category_id = $data["category_id"];
        $job_category_entity = $this->entityManager->getRepository(JobCategories::class)->findOneBy(['id'=>$category_id]);
        $ad = $this->entityManager->getRepository(Advertisements::class)->findOneBy(['id'=>$ad_id]);
        $ad->removeJobCategoriesId($job_category_entity);
        $this->entityManager->persist($ad);
        $this->entityManager->flush();

        $data = [
            "message" => true
        ];

        return new JsonResponse($data);
    }

    public function add_job_category(Request $request):JsonResponse
    {
        $post_data = $request->getContent();
        $data = json_decode($post_data,true);

        $ad_id = $data["ad_id"];
        $category_name = $data["category_name"];
        $job_category_entity = $this->entityManager->getRepository(JobCategories::class)->findOneBy(['name'=>$category_name]);
        $ad = $this->entityManager->getRepository(Advertisements::class)->findOneBy(['id'=>$ad_id]);
        $ad->addJobCategoriesId($job_category_entity);
        $this->entityManager->persist($ad);
        $this->entityManager->flush();

        $data = [
            "message" => true
        ];

        return new JsonResponse($data);
    }

    public function set_candidate_user(Security $security,Request $request):JsonResponse
    {
        $user_email = $security->getUser()->getUserIdentifier();
        $is_companie = $this->isGranted("ROLE_COMPAINE");

        $post_data = $request->getContent();
        $data = json_decode($post_data,true);

        $ad_id = $data["ad_id"];

        if ($is_companie){
            $data = [
                "message" => "Is Compte Companie!"
            ];

            $res = new JsonResponse($data);
            $res->setStatusCode(400);
        }

        $ad = $this->entityManager->getRepository(Advertisements::class)->findOneBy(["id"=>$ad_id]);
        $user_profile = $this->entityManager->getRepository(User::class)->findOneBy(["email"=>$user_email])->getUserProfile();
        $user_profile->addAdvertisement($ad);
        $this->entityManager->persist($user_profile);
        $this->entityManager->flush();

        $data = [
            "message"=>"true"
        ];

        $res = new JsonResponse($data);
        $res->setStatusCode(200);

        return $res;
    }

    public function set_candidate_anonymous(Request $request):JsonResponse
    {
        try {
            $cvFile = $request->files->get("pdf");
            $fileContent = file_get_contents($cvFile->getPathname());
            $anony = new CandidateAnonymous();
            $anony->setPhone($request->get("phone"));
            $anony->setLm($request->get("lm"));
            $anony->setEmail($request->get("email"));
            $anony->setContent($request->get("content"));
            $anony->addAdvertisement($this->entityManager->getRepository(Advertisements::class)->findOneBy(["id"=>$request->get("ad_id")]));
            $anony->setCv($fileContent);
            $this->entityManager->persist($anony);
            $this->entityManager->flush();

            $data = [
                "message" => true
            ];


            return new JsonResponse($data);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }

    }

}