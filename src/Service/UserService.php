<?php


namespace App\Service;


use App\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public  function  findUserById($userId){

        return $this->userRepository->find($userId);
    }

    public function UserAllNewest()
    {
        $users = $this->userRepository->findAllByNewest();

        return $users;

        // $users1 = $this->userRepository->findAllCreatedBy();
        //dd($users1);
    }
}