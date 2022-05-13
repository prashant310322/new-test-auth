<?php

namespace App\Controller;

use App\Entity\User;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct( private  UserRepository $userRepository)
    {
    }
    #[Route('/user', name: 'app_user')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
       $result = $request->request->all();

       //dd($result);
        $users = $this->userRepository->findAll();


        if (!empty($result))
        {
            if ($result['submit'] == "submit"){
                // dd('hello');

                $user = new User();

                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $result['_password']
                    )
                );

                $user->setFirstName($result['_first_name']);
                $user->setLastName($result['_last_name']);
                $user->setPhoneNumber($result['_phone_number']);
                $user->setEmail($result['_username']);
               $user->setCreatedBy($result['userlog']);

                $entityManager->persist($user);
                $entityManager->flush();

                $error = '';
                $email = $user->getEmail();

                return $this->render('index/index.html.twig', [
                    'controller_name' => 'IndexController',
                    'users' => $users,
                    'email' => $email,
                ]);
            }
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',

        ]);
    }
}
