<?php


namespace App\Dto;



use App\Entity\User;

class UserInputDto
{
    public ?string $email = null;

    public ?string $password = null;

    public ?string $username = null;

    public ?string $firstName = null;

    public ?string $lastName  = null;


    public ?string $phoneNumber = null;

    public static  function createFromEntity(?User $user): self
    {
        $dto = new UserInputDto();

        // not an edit, so just return an empty DTO
        if (!$user) {
            return $dto;
        }

        $dto->email = $user->getEmail();
        $dto->firstName = $user->getFirstName();
        $dto->lastName = $user->getLastName();
        $dto->username = $user->getUsername();
        $dto->phoneNumber = $user->getPhoneNumber();
        return $dto;

    }

    public function toEntity(?User $user): User
    {
        $user = $user ?? new User();

        $user->setEmail($this->email)
            ->setPassword($this->password)
            ->setFirstName(($this->firstName))
            ->setLastName($this->lastName)
        ;

        return $user;
    }
}