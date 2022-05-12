<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    public function __construct( private  UserRepository $userRepository)
    {
    }

    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
       // dd($this);
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $users = $this->userRepository->findAll();

        //dd($users);

        //dump($this->container->get('security.token_storage')->getToken());

        //dd('hello');
        $user = $this->getUser();
       // dd($user);
        $email = $user->getEmail();

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'users' => $users,
            'email' => $email,
        ]);
    }
}
