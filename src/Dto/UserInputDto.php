<?php


namespace App\Dto;



use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class UserInputDto
{

    public $id;

    #[Groups(["user.read", "user.write"])]
    public ?string $email = null;

    #[Groups(["user.write"])]
    public ?string $password = null;

    #[Groups(["user.write"])]
    public $roles = [];


    public ?string $username = null;

    #[Groups(["user.read", "user.write"])]
    public ?string $firstName = null;

    #[Groups(["user.read", "user.write"])]
    public ?string $lastName  = null;


    #[Groups(["user.read", "user.write"])]
    public ?string $phoneNumber = null;

    #[Groups(["user.read"])]
    public ?string $createdBy = null;

    public static  function createFromEntity(?User $user): self
    {
        $dto = new UserInputDto();

        dump($user, $dto);

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
             ->setFirstName(($this->firstName))
             ->setLastName($this->lastName)
             ->setPhoneNumber($this->phoneNumber);

        if(!empty($this->password))
        {
            $user->setPassword($this->password);
        }

        return $user;
    }
}