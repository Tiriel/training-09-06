<?php

namespace App\Consumer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OMDbApiConsumer
{
    public const MODE_ID = 'i';
    public const MODE_SEARCH = 's';
    public const MODE_TITLE = 't';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $omdbClient)
    {
        $this->client = $omdbClient;
    }

    public function consume(string $type, string $value) : array
    {
        if (!\in_array($type, [self::MODE_ID, self::MODE_SEARCH, self::MODE_TITLE])) {
            throw new \InvalidArgumentException(sprintf("Invalid mode provided for consumer : %s, %s, or %s allowed, %s given",
                self::MODE_ID, self::MODE_SEARCH, self::MODE_TITLE, $type));
        }

        $data = $this->client
            ->request(Request::METHOD_GET, '', ['query' => [$type => $value]])
            ->toArray();

        if (array_key_exists('Response', $data) && $data['Response'] === 'False') {
            throw new NotFoundHttpException(sprintf("Movie not found for %s = %s", $type, $value));
        }

        return $data;
    }
}
