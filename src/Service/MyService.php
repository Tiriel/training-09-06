<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;

final class MyService implements ServiceInterface
{
    public const ENV_VAR = 'bar';
    private EntityManagerInterface $manager;
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer, ManagerRegistry $myVar)
    {
        $this->mailer = $mailer;
    }

    /**
     * @required
     */
    public function setEntityManager(EntityManagerInterface $manager)
    {

    }

    public function doSomething()
    {
        // TODO: Implement doSomething() method.
    }
}