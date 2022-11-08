<?php

namespace Ecodenl\LvbagPhpWrapper;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;

class Client
{
    protected string $baseUrl = "https://api.bag.acceptatie.kadaster.nl/lvbag/individuelebevragingen/v2/";

    private GuzzleClient $client;

    public function __construct(string $secret, string $crs, ?string $baseUrl = null, bool $debugMode = false)
    {
        $config = [
            'base_uri'        => $baseUrl ?? $this->baseUrl,
            'headers'         => [
                'Accept'       => 'application/hal+json',
                'X-Api-Key' => $secret,
                'Accept-CRS' => $crs
            ],
            'allow_redirects' => false,
        ];

        if ($debugMode) {
            $stack = new HandlerStack();
            $stack->setHandler(new CurlHandler());
            $middleware = Middleware::tap(function (Request $request) {
                var_dump($request->getRequestTarget());
            });
            $stack->push($middleware);
            $config['handler'] = $stack;
        }

        $this->client = new GuzzleClient($config);
    }


    public function client(): GuzzleClient
    {
        return $this->client;
    }

    public function request(string $method, string $uri, array $options = []): array
    {
        $response = $this->client()->request($method, $uri, $options);

        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
    }

    public function get(string $uri, array $options = []): array
    {
        return $this->request('GET', $uri, $options);
    }

}
