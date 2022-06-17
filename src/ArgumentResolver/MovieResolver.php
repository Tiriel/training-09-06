<?php

namespace App\ArgumentResolver;

use App\Entity\Movie;
use App\Provider\MovieProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class MovieResolver implements ArgumentValueResolverInterface
{
    private MovieProvider $provider;

    public function __construct(MovieProvider $provider)
    {
        $this->provider = $provider;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return Movie::class === $argument->getType() && $request->request->has('title');
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $this->provider->getByTitle($request->request->get('title'));
    }
}