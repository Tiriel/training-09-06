<?php

namespace App\Service;

class OtherService implements ServiceInterface
{
    private MyService $service;

    public function __construct(MyService $service)
    {
        $this->service = $service;
    }

    public function doSomething()
    {
        // ...
        $this->service->doSomething();
        // TODO: Implement doSomething() method.
    }
}