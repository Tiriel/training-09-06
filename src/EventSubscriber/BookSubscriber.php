<?php

namespace App\EventSubscriber;

use App\Event\BookOrderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BookSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        // ...
    }

    public function onBookOrder(BookOrderEvent $event)
    {
        $book = $event->getBook();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 2048],
            BookOrderEvent::ORDER => ['onBookOrder', 0],
        ];
    }
}
