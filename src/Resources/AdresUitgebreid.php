<?php

namespace Ecodenl\LvbagPhpWrapper\Resources;

class AdresUitgebreid extends Resource
{
    /**
     * Returns specific data about the given identification.
     *
     * @param  string  $nummeraanduidingIdentificatie
     *
     * @return array
     */
    public function show(string $nummeraanduidingIdentificatie): array
    {
        return $this->client->get($this->uri($nummeraanduidingIdentificatie));
    }

    /**
     * Returns a list of address(es) from given attributes.
     *
     * @param  array  $attributes
     *
     * @return array
     */
    public function list(array $attributes): array
    {
        $response = $this->client->get($this->uri, static::buildQuery($this->paginate() + $attributes));

        return $response['_embedded']['adressen'] ?? [];
    }
}
