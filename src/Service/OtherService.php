<?php

namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class OtherService implements ServiceInterface
{
    private MyService $service;
    private AuthorizationCheckerInterface $checker;
    private TokenStorageInterface $tokenStorage;

    public function __construct(MyService $service, AuthorizationCheckerInterface $checker, TokenStorageInterface $tokenStorage)
    {
        $this->service = $service;
        $this->checker = $checker;
        $this->tokenStorage = $tokenStorage;
    }

    public function doSomething()
    {
        if (!$this->checker->isGranted('ROLE_TRUC')) {
            $user = $this->tokenStorage->getToken()->getUser();
        }
        // ...
        $this->service->doSomething();
        // TODO: Implement doSomething() method.
    }
}