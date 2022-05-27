<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\UserInputDto;
use App\Dto\UserOutputDto;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
#[ORM\EntityListeners(["App\Doctrine\UserSetUsernameListener"])]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource(
    normalizationContext: ['groups' => ['user.read' ]],
    denormalizationContext: ['groups'=>['user.write']],
    input:UserInputDto::class
   )]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["user.write"])]
    private $email;

    #[ORM\Column(type: 'json')]
    #[Groups(["user.write"])]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(["admin.read", "admin.write"])]
    private $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true, unique: true)]
    #[Groups(["user.read"])]
    private $username;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["user.read", "user.write"])]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["user.read", "user.write"])]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["admin.read"])]
    private $phoneNumber;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(["user.read"])]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(["user.read"])]
    private $updatedAt;


    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(["user.read"])]
    private $deletedAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["user.read"])]
    private $createdBy;


    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["user.read"])]
    private $updatedBy;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["user.read"])]
    private $deletedBy;

    /**
     * Returns true if this is currently-authenticated user
     */
    #[Groups(["user.read"])]
    private $isMe =false;

    #[Groups(["admin.read", "admin.write"])]
    #[SerializedName('password')]
    private $plainPassword;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Address::class, cascade: ['persist', 'remove'])]
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    #[Groups(["admin.read"])]
    public function getPhoneNumberFormat(): ?string
    {
        return  '******' . substr($this->phoneNumber, -4);
    }

    #[Groups(["user.read"])]
    public function getCreatedAtFormat(): ?string
    {
        //$convertDate =  new \DateTimeImmutable($this->createdAt);
        return  $this->createdAt->format('d/m/Y');

    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?int $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?int $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

   

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDeletedBy(): ?int
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?int $deletedBy): self
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    /**
     * @ORM\PostPersist()
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return mixed
     */
    public function getIsMe():bool
    {
//        if($this->isMe == null){
//            throw new \LogicException('this isme field is not initialized');
//        }
        return $this->isMe;
    }

    /**
     * @param mixed $isMe
     */
    public function setIsMe(bool $isMe): void
    {
        $this->isMe = $isMe;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return  $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        // unset the owning side of the relation if necessary
        if ($address === null && $this->address !== null) {
            $this->address->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($address !== null && $address->getUser() !== $this) {
            $address->setUser($this);
        }

        $this->address = $address;

        return $this;
    }



}
