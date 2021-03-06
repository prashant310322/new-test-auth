<?php

namespace App\Serializer;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Entity\User;

final class AdminGroupsContextBuilder implements SerializerContextBuilderInterface
{
    private $decorated;
    private $authorizationChecker;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
       //$resourceClass = $context['resource_class'] ?? null;

        $context['groups'] = $context['groups'] ?? [];

        $isAdmin = $this->authorizationChecker->isGranted('ROLE_ADMIN');
        //dd($isAdmin);

        if ($isAdmin) {
            $context['groups'][] = $normalization ? 'admin.read' : 'admin.write';
        }

        //dump($context['groups']);
        $context['groups'] = array_unique($context['groups']);

        return $context;
    }
}

