<?php


namespace App\Dto;



use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

class UserInputDto
{

    public $id;

    #[Groups(["user.read", "user.write"])]
    public ?string $email = null;


    public ?string $password = null;

    #[Groups(["admin.read", "admin.write"])]
    #[SerializedName('password')]
    public $plainPassword;

    #[Groups(["user.write"])]
    public $roles = [];


    public ?string $username = null;

    #[Groups(["user.read", "user.write"])]
    public ?string $firstName = null;

    #[Groups(["user.read", "user.write"])]
    public ?string $lastName  = null;


    #[Groups(["admin.read"])]
    public ?string $phoneNumber = null;

    #[Groups(["user.read"])]
    public ?string $createdBy = null;

    #[Groups(["user.read"])]
    public ?bool $isMe = false;

    public static  function createFromEntity(?User $user): self
    {
        $dto = new UserInputDto();

       // dump($user, $dto);

        // not an edit, so just return an empty DTO
        if (!$user) {
            return $dto;
        }


        $dto->email = $user->getEmail();
        $dto->firstName = $user->getFirstName();
        $dto->plainPassword = $user->getPassword();
        $dto->lastName = $user->getLastName();
        $dto->username = $user->getUsername();
        $dto->phoneNumber = $user->getPhoneNumber();
        $dto->roles   = $user->getRoles();
        $dto->isMe    = $user->getIsMe();

        return $dto;

    }

    public function toEntity(?User $user): User
    {
        $user = $user ?? new User();

        $user->setEmail($this->email)
             ->setFirstName(($this->firstName))
             ->setLastName($this->lastName)
            ->setPlainPassword($this->plainPassword)
            ->setRoles($this->roles)
            ->setPhoneNumber($this->phoneNumber);


        if(!empty($this->password))
        {
            $user->setPassword($this->password);
        }

        return $user;
    }
}