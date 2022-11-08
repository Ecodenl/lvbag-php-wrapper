<?php

namespace Ecodenl\LvbagPhpWrapper\Resources;

use Ecodenl\LvbagPhpWrapper\Client;

abstract class Resource
{
    /** @var Client $client */
    protected Client $client;

    protected string $uri;

    public function __construct(Client $client, string $uri)
    {
        $this->client = $client;
        $this->uri = $uri;
    }

    public function uri(string $params = ''): string
    {
        return implode('/', [$this->uri, $params]);
    }
}
