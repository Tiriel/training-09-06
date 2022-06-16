<?php

namespace App\Provider;

use App\Consumer\OMDbApiConsumer;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Transformer\MovieTransformer;

class MovieProvider
{
    private OMDbApiConsumer $consumer;
    private MovieTransformer $transformer;
    private MovieRepository $repository;

    public function __construct(OMDbApiConsumer $consumer, MovieTransformer $transformer, MovieRepository $repository)
    {
        $this->consumer = $consumer;
        $this->transformer = $transformer;
        $this->repository = $repository;
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
