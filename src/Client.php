<?php

namespace Ecodenl\LvbagPhpWrapper;

use Ecodenl\LvbagPhpWrapper\Traits\FluentCaller;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;

class Client
{
    use FluentCaller;

    protected string $baseUrl = "https://api.bag.acceptatie.kadaster.nl/lvbag/individuelebevragingen/v2/";

    private array $config;

    private ?GuzzleClient $client = null;

    private ?LoggerInterface $logger;

    public function __construct(string $secret, string $crs, bool $useProductionEndpoint = false, LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        if ($useProductionEndpoint) {
            $this->baseUrl = 'https://api.bag.kadaster.nl/lvbag/individuelebevragingen/v2';
        }

        $this->config = [
            'base_uri'        => $this->baseUrl,
            'headers'         => [
                'Accept'     => 'application/hal+json',
                'X-Api-Key'  => $secret,
                'Accept-CRS' => $crs,
            ],
            'allow_redirects' => false,
        ];
    }

    public function getClient()
    {
        if (is_null($this->client)) {
            if ($this->logger instanceof LoggerInterface) {
                $stack = new HandlerStack();
                $stack->setHandler(new CurlHandler());
                $middleware = Middleware::tap(function (Request $request) {
                    $this->logger->log(__CLASS__, [
                        'headers' => $request->getHeaders(),
                        'queryString' => $request->getUri()->getQuery(),
                    ]);
                });
                $stack->push($middleware);
                $this->config['handler'] = $stack;
            }

            $this->client = new GuzzleClient($this->config);
        }

        return $this->client;
    }

    public function request(string $method, string $uri, array $options = []): array
    {
        $response = $this->getClient()->request($method, $uri, $options);

        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
    }

    public function get(string $uri, array $options = []): array
    {
        return $this->request('GET', $uri, $options);
    }

}
