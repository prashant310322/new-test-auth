<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements  DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $hasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
    }

    public function supports($data): bool
    {

        return $data instanceof  User;
    }

    public function persist($data)
    {

        if ($data->getPlainPassword()) {
           // dd($data);
            $this->hashPassword($data);
        }
        $data->eraseCredentials();
        $data->setIsMe(true);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

    private function hashPassword(User $user)
    {
        $password = $this->hasher->hashPassword($user, $user->getPlainPassword());
       //  dd($password);
        $user->setPassword($password);
    }

}