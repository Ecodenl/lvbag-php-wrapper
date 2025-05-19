# LVBAG PHP Api Wrapper

A simple PHP wrapper for IMBAG API (LVBAG)

## Version Information

To keep versioning simple, the package version is aligned with the LV BAG API version.

| Package version | API Version | Status                  | PHP Version    |
|:----------------|:------------|:------------------------|:---------------|
| 2.1.x           | 2.x.x       | Active support :rocket: | ^8.2           |
| 2.0.x           | 2.x.x       | No active support :x:   | ^7.4.0 \| ^8.0 |


## Installing

```
composer require ecodenl/lvbag-php-wrapper
```

***

# Using the API

## Read the official API docs

To get a basic understanding of what is possible and what isn't, you should
read [the official api docs](https://lvbag.github.io/BAG-API/Technische%20specificatie/).

## Setting up the connection

```php
use Ecodenl\LvbagPhpWrapper\Client;
use Ecodenl\LvbagPhpWrapper\Lvbag;
use Ecodenl\LvbagPhpWrapper\Resources\AdresUitgebreid;

$secret = 'asecretcodeyouneedtoobtain';
// crs is not static, you should change it accordingly to the desired call.
$acceptCRS = 'epsg:28992';

// Establish the connection
$client = Client::init($secret, $acceptCRS);

// Using the production environment endpoint
$shouldUseProductionEndpoint = true;
$client = Client::init($secret, $acceptCRS, $shouldUseProductionEndpoint);

// To get extensive logging from each request
// the client accepts any logger that follows the (PSR-3 standard)[https://github.com/php-fig/log]
// This example uses the logger from laravel, but feel free to pass any logger that implements the \Psr\Log\LoggerInterface
$logger = \Illuminate\Support\Facades\Log::getLogger();
$client = Client::init($secret, $acceptCRS, $shouldUseProductionEndpoint, $logger);

$lvbag = Lvbag::init($client);


```

## Resources
### Adres uitgebreid

[Documentation](https://lvbag.github.io/BAG-API/Technische%20specificatie/#/Adres%20uitgebreid).  
Based on given address data.

```php
// Get all available addresses from te given data
$addresses = $lvbag->adresUitgebreid()
  ->list([
    'postcode' => '3255MC',
    'huisnummer' => 13,
  ]);

// Only return the exact match 
$address = $lvbag->adresUitgebreid()
  ->list([
    'postcode' => '3255MC',
    'huisnummer' => 13,
    'exacteMatch' => true
  ]);
  
// Only return the exact match 
$address = $lvbag->adresUitgebreid()
  ->list([
    'postcode' => '3255MC',
    'huisnummer' => 13,
    'huisletter' => 'd',
    'exacteMatch' => true,
  ]);
```

The nummeraanduidingIdentificatie will be returned from the `->list()` call, this call can be useful when you need to
get the properties again (for whatever reason).

```php
$lvbag->adresUitgebreid()->show('1924200000030235');
```

### Pagination
Every list method will return a paginated response:

```php
// return page 2
$addresses = $lvbag->adresUitgebreid()
   ->page(2)
   ->list([
      'postcode' => '3255MC',
      'huisnummer' => 13,
   ]);
   
// Its also possible to change the amount per page.
$addresses = $lvbag->adresUitgebreid()
   ->pageSize(12)
   ->page(2)
   ->list([
      'postcode' => '3255MC',
      'huisnummer' => 13,
   ]);
```

### Woonplaats

[Documentation](https://lvbag.github.io/BAG-API/Technische%20specificatie/#/Woonplaats).  
When calling to `adresUitgebreid()`, an address will contain a `woonplaatsIdentificatie`. This identification can be
used to retrieve info about the city of an address:

```php
$woonplaatsIdentification = '2134';
$woonplaats = $lvbag->woonplaats()->show($woonplaatsIdentification);

// Pass attributes as second parameter to retrieve more info
$woonplaats = $lvbag->woonplaats()->show($woonplaatsIdentification, [
    // Supports "bronhouders", "geometrie" or "true" (STRING!). "true" returns both.
    'expand' => 'bronhouders',  
]);

// This way one can retrieve the municipality of a city. 
$woonplaats['_embedded']['bronhouders']
```

In the case one doesn't know the identification, you can still call the list with attributes (pagination applies):

```php
$woonplaatsen = $lvbag->woonplaats()->list([
    'naam' => 'Oude-tonge',
    'expand' => 'bronhouders',  
]);
```
