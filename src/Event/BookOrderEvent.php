<?php

namespace App\Event;

use App\Entity\Book;
use Symfony\Contracts\EventDispatcher\Event;

class BookOrderEvent extends Event
{
    public const ORDER = 'book.order';

    private Book $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function setBook(Book $book): BookOrderEvent
    {
        $this->book = $book;

        return $this;
    }
}