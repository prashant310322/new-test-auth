<?php


namespace App\DataTransformer;


use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\UserOutputDto;
use App\Entity\User;
use App\Repository\UserRepository;

class UserOutputDataTransfomer implements  DataTransformerInterface
{
     public function __construct(private  UserRepository $userRepository)
     {
     }

    /**
     * @param UserOutputDto $userOutputDto
     * @param string $to
     * @param array $context
     * @return object
     */
    public function transform($userOutputDto, string $to, array $context = [])
    {
       //dump($userOutputDto->getEmail());
        $createdName = $this->userRepository->find($userOutputDto->getCreatedBy());
        $createdName= $createdName->getFirstName();
        return UserOutputDto::createFromEntity($userOutputDto, $createdName);

    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
       // dump($data, $to);
        return $data instanceof  User && $to === UserOutputDto::class ;
    }

}