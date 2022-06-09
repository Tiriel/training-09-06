<?php

namespace App\Controller;

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
     * @Route("/details", name="details", methods={"GET"})
     */
    public function details(): Response
    {
        $movie = [
            'title' => 'Star Wars: A New Hope',
            'releasedAt' => new \DateTime('1977-05-25'),
            'genres' => ['Action', 'Adventure', 'Fantasy'],
        ];

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }
}
