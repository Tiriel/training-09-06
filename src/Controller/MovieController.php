<?php

namespace App\Controller;

use App\Consumer\OMDbApiConsumer;
use App\Event\MovieOrderEvent;
use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use App\Security\Voter\MovieRatingVoter;
use App\Service\MyService;
use App\Service\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/movie", name="app_movie_")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    /**
     * @Route("/{title<\w+>}", name="details", methods={"GET"})
     */
    public function details(string $title, MovieProvider $provider, EventDispatcherInterface $dispatcher): Response
    {
        $movie = $provider->getByTitle($title);
        $this->denyAccessUnlessGranted(MovieRatingVoter::RATING, $movie);
        $dispatcher->dispatch(new MovieOrderEvent($movie), MovieOrderEvent::ORDER);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }
}
