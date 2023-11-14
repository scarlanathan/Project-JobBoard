<?php

namespace App\ApiResource;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ApiLogoutController extends AbstractController
{

    public function index(Request $request):JsonResponse
    {

        if (isset($_COOKIE['BEARER'])) {
            unset($_COOKIE['BEARER']);
            setcookie('BEARER', '', -1, '/');
        }

        $data = [
            "logout" => true
        ];

        return new JsonResponse($data);
    }

}