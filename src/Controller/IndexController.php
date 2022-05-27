<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;

class IndexController extends AbstractController
{


    private UserService $userService;
    private AddressRepository $addressRepository;

    public function __construct( UserService $userService , AddressRepository $addressRepository)
    {

        $this->userService = $userService;
        $this->addressRepository = $addressRepository;
    }

    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
       // dd($this);
        $address = $this->addressRepository->findUserById(22);
       // dd($address);
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $users =  $this->userService->UserAllNewest();

        dd($users);

//        $users = $this->userRepository->findAllByNewest();
//
//        $users1 = $this->userRepository->findAllCreatedBy();
//        dd($users1);

        //dump($this->container->get('security.token_storage')->getToken());

        //dd('hello');
       // $user = $this->getUser();
       // dd($user);
      //  $email = $user->getEmail();

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'users' => $users,
            'email' => $email,
        ]);
    }
}
