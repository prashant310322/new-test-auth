<?php


namespace App\DataTransformer;


use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Dto\UserInputDto;
use App\Dto\UserOutputDto;
use App\Entity\User;
use App\Repository\UserRepository;

class UserInputDataTransformer implements  DataTransformerInterface
{
    public function __construct(private  UserRepository $userRepository)
    {
    }

    /**
     * @param UserInputDto $userInputDto
     * @param string $to
     * @param array $context
     * @return object|void
     */
    public function transform($userInputDto, string $to, array $context = [])
    {

        $users = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE] ?? null;

        return $userInputDto->toEntity($users);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {

        return User::class === $to && UserInputDto::class === ($context['input']['class'] ?? null);
    }


}