<?php


namespace App\Serializer\Normalizer;


use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Dto\UserInputDto;
use App\Entity\User;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserInputDenormalizer implements  DenormalizerInterface, CacheableSupportsMethodInterface
{


    private  ObjectNormalizer $normalizer;


    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        dump($data);

        $context[AbstractItemNormalizer::OBJECT_TO_POPULATE] = $this->createDto($context);

        dump($context);

            return $this->normalizer->denormalize($data, $type, $format, $context);


    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        dump($data, $type);
        return UserInputDto::class === $type ;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    private function createDto(array $context): UserInputDto
    {
        $entity =   $context['object_to_populate']  ?? null;

        if ($entity && !$entity instanceof User) {
            throw new \Exception(sprintf('Unexpected resource class "%s"', get_class($entity)));
        }

        return UserInputDto::createFromEntity($entity);
    }

}