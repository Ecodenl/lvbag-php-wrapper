<?php

namespace Ecodenl\LvbagPhpWrapper\Resources;

use Ecodenl\LvbagPhpWrapper\Client;
use GuzzleHttp\RequestOptions;

abstract class Resource
{
    protected Client $client;

    protected int $page = 1;
    protected int $pageSize = 15;

    protected string $uri;

    public function __construct(Client $client, string $uri)
    {
        $this->client = $client;
        $this->uri    = $uri;
    }

    public function uri(string $params = ''): string
    {
        return implode('/', [$this->uri, $params]);
    }

    public function page(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function pageSize(int $pageSize): self
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }


    public function getPage(): int
    {
        return $this->page;
    }


    protected function paginate(): array
    {
        $query['page']     = $this->getPage();
        $query['pageSize'] = $this->getPageSize();

        return $query;
    }

    protected static function buildQuery(array $attributes): array
    {
        return [
            RequestOptions::QUERY => $attributes,
        ];
    }
}
