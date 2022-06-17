<?php

namespace App\Provider;

use App\Consumer\OMDbApiConsumer;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Transformer\MovieTransformer;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MovieProvider
{
    private OMDbApiConsumer $consumer;
    private MovieTransformer $transformer;
    private MovieRepository $repository;
    private AuthorizationCheckerInterface $checker;

    public function __construct(OMDbApiConsumer $consumer, MovieTransformer $transformer, MovieRepository $repository, AuthorizationCheckerInterface $checker)
    {
        $this->consumer = $consumer;
        $this->transformer = $transformer;
        $this->repository = $repository;
        $this->checker = $checker;
    }

    public function updateMovie(Movie $movie)
    {
        if ($this->checker->isGranted('movie_edit', $movie)) {
            throw new UnauthorizedHttpException('Unauthorized');
        }
    }

    public function getById(string $id): Movie
    {
        return $this->getOneMovie(OMDbApiConsumer::MODE_ID, $id);
    }

    public function getByTitle(string $title): Movie
    {
        return $this->getOneMovie(OMDbApiConsumer::MODE_TITLE, $title);
    }

    private function getOneMovie(string $type, string $value): Movie
    {
        $property = $type === OMDbApiConsumer::MODE_TITLE ? 'title' : 'id';

        $movie = $this->repository->findOneBy([$property => $value]) ?? $this->transformer->arrayToMovie(
                $this->consumer->consume($type, $value)
            );

        if (!$movie->getId()) {
            $this->repository->add($movie, true);
        }

        return $movie;
    }
}
