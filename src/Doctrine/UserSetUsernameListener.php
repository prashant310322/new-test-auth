<?php


namespace App\Doctrine;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserSetUsernameListener
{
    public function __construct( private  UserRepository $userRepository)
    {
    }

    public  function prePersist(User $user )
    {

        $time = new \DateTimeImmutable();

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