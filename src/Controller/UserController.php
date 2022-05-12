<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
       $result = $request->request->all();

       //dd($result);



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

                $user->setEmail($result['_username']);
               $user->setCreatedBy($result['userlog']);

                $entityManager->persist($user);
                $entityManager->flush();

                $error = '';

                return $this->render('login/index.html.twig', ['controller_name' => 'LoginController',
                    'last_username' => '','error'=>$error]);
            }
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',

        ]);
    }
}
