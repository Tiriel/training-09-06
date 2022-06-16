<?php

namespace App\Service;

class DecoratorService implements ServiceInterface
{
    private OtherService $service;

    public function __construct(OtherService $service)
    {
        $this->service = $service;
    }

    public function doSomething()
    {
        // ..
        $this->service->doSomething();
    }
}