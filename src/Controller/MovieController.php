<?php

namespace App\Controller;

use App\Consumer\OMDbApiConsumer;
use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use App\Service\MyService;
use App\Service\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/{title<.+>}", name="details", methods={"GET"})
     */
    public function details(string $title, MovieProvider $provider): Response
    {
        $movie = $provider->getByTitle($title);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }
}
