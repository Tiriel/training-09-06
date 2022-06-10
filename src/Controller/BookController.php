<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function new(Request $request, BookRepository $repository)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($book, true);

            return $this->redirectToRoute('app_book_new');
        }

        return $this->renderForm('book/new.html.twig', [
            'book_form' => $form,
        ]);
    }
}
