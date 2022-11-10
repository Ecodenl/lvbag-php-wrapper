<?php

namespace Ecodenl\LvbagPhpWrapper;

use Ecodenl\LvbagPhpWrapper\Resources\AdresUitgebreid;
use Ecodenl\LvbagPhpWrapper\Traits\FluentCaller;

class Lvbag
{
    use FluentCaller;

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function info(): array
    {
        return $this->client->get('info');
    }

    public function adresUitgebreid(): AdresUitgebreid
    {
        return new AdresUitgebreid($this->client, 'adressenuitgebreid');
    }
}
