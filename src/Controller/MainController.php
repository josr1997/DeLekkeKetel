<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/@{username?}', name: 'profile-page')]
    public function viewProfilePage(Request $request): Response
    {
        $name = $request->get('username');
        return $this->render('profile/index.html.twig', [
            'name' => $name
        ]);
    }
}
