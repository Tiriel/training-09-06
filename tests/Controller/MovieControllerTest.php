<?php

namespace App\Test\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MovieRepository $repository;
    private string $path = '/admin/movie/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Movie::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Movie index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'movie[title]' => 'Testing',
            'movie[poster]' => 'Testing',
            'movie[country]' => 'Testing',
            'movie[releasedAt]' => 'Testing',
            'movie[price]' => 'Testing',
        ]);

        self::assertResponseRedirects('/admin/movie/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Movie();
        $fixture->setTitle('My Title');
        $fixture->setPoster('My Title');
        $fixture->setCountry('My Title');
        $fixture->setReleasedAt('My Title');
        $fixture->setPrice('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Movie');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Movie();
        $fixture->setTitle('My Title');
        $fixture->setPoster('My Title');
        $fixture->setCountry('My Title');
        $fixture->setReleasedAt('My Title');
        $fixture->setPrice('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'movie[title]' => 'Something New',
            'movie[poster]' => 'Something New',
            'movie[country]' => 'Something New',
            'movie[releasedAt]' => 'Something New',
            'movie[price]' => 'Something New',
        ]);

        self::assertResponseRedirects('/admin/movie/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getPoster());
        self::assertSame('Something New', $fixture[0]->getCountry());
        self::assertSame('Something New', $fixture[0]->getReleasedAt());
        self::assertSame('Something New', $fixture[0]->getPrice());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Movie();
        $fixture->setTitle('My Title');
        $fixture->setPoster('My Title');
        $fixture->setCountry('My Title');
        $fixture->setReleasedAt('My Title');
        $fixture->setPrice('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/admin/movie/');
    }
}
