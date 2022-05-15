<?php


namespace App\Serializer\Normalizer;


use App\Dto\UserInputDto;
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


    private  $normalizer;


    public function __construct(ObjectNormalizer $normalizer)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {

        $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $this->createDto($context);

        return $this->normalizer->denormalize($data, $type, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {

        return $type === UserInputDto::class;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    private function createDto(array $context): UserInputDto
    {
        $entity = $context['object_to_populate'] ?? null;

        if ($entity && !$entity instanceof User) {
            throw new \Exception(sprintf('Unexpected resource class "%s"', get_class($entity)));
        }

        return UserInputDto::createFromEntity($entity);
    }

}