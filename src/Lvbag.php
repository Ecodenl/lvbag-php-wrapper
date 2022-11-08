<?php

namespace Ecodenl\LvbagPhpWrapper;

use Ecodenl\LvbagPhpWrapper\Resources\AdresUitgebreid;

class Lvbag {

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function info(): array
    {
        return $this->client->get('info');
    }

    public function AdresUitgebreid(): AdresUitgebreid
    {
        return new AdresUitgebreid($this->client, 'adressenuitgebreid');
    }
}
