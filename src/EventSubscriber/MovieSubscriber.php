<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Event\MovieOrderEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MovieSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $manager;
    private TokenStorageInterface $storage;

    public function __construct(EntityManagerInterface $manager, TokenStorageInterface $storage)
    {
        $this->manager = $manager;
        $this->storage = $storage;
    }

    public function onMovieOrder(MovieOrderEvent $event): void
    {
        $user = $this->storage->getToken()->getUser();
        if (!$user instanceof User) {
            return;
        }
        $user->addLastMovie($event->getMovie());
        $this->manager->flush();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MovieOrderEvent::ORDER => 'onMovieOrder',
        ];
    }
}
