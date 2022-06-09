<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book", name="app_book_", methods={"GET"})
 */
class BookController extends AbstractController
{
    /**
     * @Route("/{page<\d+>?1}", name="index")
     */
    public function index(int $page): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"POST"})
     */
    public function new()
    {
        return new Response();
    }
}
