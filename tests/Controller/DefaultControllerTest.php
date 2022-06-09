<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function provideUrlsAndStatusCodes(): array
    {
        return [
            ['/', 200],
            ['/contact', 200],
            ['/book', 200],
            ['/book/new', 200],
            ['/toto', 404],
        ];
    }

    /**
     * @dataProvider provideUrlsAndStatusCodes
     */
    public function testPublicUrlsAreSuccessful(string $url, int $statusCode): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame($statusCode);
    }

    /**
     * @group fake
     */
    public function testAssertionIsGood()
    {
        $this->assertEquals(20, 20);
    }
}
