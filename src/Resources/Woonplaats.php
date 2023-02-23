<?php

namespace Ecodenl\LvbagPhpWrapper\Resources;

class Woonplaats extends Resource
{
    /**
     * Returns specific data about the given identification.
     *
     * @param  string  $identificatie
     * @param  array  $attributes
     *
     * @return array
     */
    public function show(string $identificatie, array $attributes = []): array
    {
        return $this->client->get($this->uri($identificatie), static::buildQuery($attributes));
    }

    /**
     * Returns a list of cities from given attributes.
     *
     * @param  array  $attributes
     *
     * @return array
     */
    public function list(array $attributes): array
    {
        $response = $this->client->get($this->uri, static::buildQuery($this->paginate() + $attributes));

        return $response['_embedded']['woonplaatsen'] ?? [];
    }
}
