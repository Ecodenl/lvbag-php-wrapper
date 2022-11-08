#  LVBAG PHP Api Wrapper
A simple PHP wrapper for IMBAG API (LVBAG)

## Installing
```
composer require ecodenl/lvbag-php-wrapper
```
***
# Using the API

## Read the official API docs.
To get a basic understanding of what is possible and what isn't, you should read [the official api docs](https://lvbag.github.io/BAG-API/Technische%20specificatie/#/Adres%20uitgebreid).

## Setting up de connection

```php
use Ecodenl\LvbagPhpWrapper\Client;
use Ecodenl\LvbagPhpWrapper\Lvbag;
use Ecodenl\LvbagPhpWrapper\Resources\AdresUitgebreid;

$secret = 'asecretcodeyouneedtoobtain';
$acceptCRS = 'epsg:28992';

// Establish the connection
$client = Client::init($secret, $acceptCRS);
$lvbag = Lvbag::init($client);
```

## Adres uitgebreid
### Based on given address data 
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
### Based on the nummeraanduidingIdentificatie
The nummeraanduidingIdentificatie will be returned from the `->list()` call, this call can be usefull when you need to get the properties again (for whatever reason).
```php
$lvbag->adresUitgebreid()->show('1924200000030235');
```

