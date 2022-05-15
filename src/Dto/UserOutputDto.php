<?php


namespace App\Dto;


use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class UserOutputDto
{
    #[Groups(["user.read"])]
    public ?string $email = null;

    #[Groups(["user.read"])]
    public ?string $username = null;

    #[Groups(["user.read"])]
    public ?string $firstName = null;

    #[Groups(["user.read"])]
    public ?string $lastName  = null;


    #[Groups(["user.read"])]
    public ?string $phoneNumber = null;

    #[Groups(["user.read"])]
    public ?string $createdBy = null;

    #[Groups(["user.read"])]
    public ?string $createdByName = null;

    public static function createFromEntity(User $user, $createdName):self
    {
        $output = new UserOutputDto();
        $output->email = $user->getEmail();
        $output->firstName = $user->getFirstName();
        $output->lastName =  $user->getLastName();
        $output->username =  $user->getUsername();
        $output->phoneNumber = $user->getPhoneNumber();
        $output->createdBy  = $user->getCreatedBy();
        $output->createdByName = $createdName;

        return $output;
    }
}