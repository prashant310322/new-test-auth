<?php


namespace App\Doctrine;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class UserSetUsernameListener
{
    public function __construct( private  UserRepository $userRepository, private Security $security)
    {
    }

    public  function prePersist(User $user )
    {

        $time = new \DateTimeImmutable();

        $loginUser = $this->security->getUser();

        if($loginUser)
        {
            $id = $loginUser->getId();
            $user->setCreatedBy($id);
        }

        $user->setCreatedAt($time);
        $this->checkUnique($user);

    }

    private function  checkUnique(User $user)
    {
        $mt = mt_rand(10000, 99999);

        // $mt = 70737;
        $usernames= array();

        $all = $this->userRepository->findAll();

        foreach ($all as $a)
        {
            $usernames[]= $a->getUsername();
        }

        if(!in_array($mt, $usernames))
        {
            $user->setUsername($mt);
        }
        else {
            //$mt = $mt + 1;
            $this->checkUnique($user);
        }


    }
}