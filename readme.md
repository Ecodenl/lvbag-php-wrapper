# LVBAG PHP Api Wrapper

A simple PHP wrapper for IMBAG API (LVBAG)

## Installing

```
composer require ecodenl/lvbag-php-wrapper
```

***

# Using the API

## Read the official API docs.

To get a basic understanding of what is possible and what isn't, you should
read [the official api docs](https://lvbag.github.io/BAG-API/Technische%20specificatie/#/Adres%20uitgebreid).

## Setting up de connection

```php
use Ecodenl\LvbagPhpWrapper\Client;
use Ecodenl\LvbagPhpWrapper\Lvbag;
use Ecodenl\LvbagPhpWrapper\Resources\AdresUitgebreid;

$secret = 'asecretcodeyouneedtoobtain';
// crs is not static, you should change it accordingly to the desired call.
$acceptCRS = 'epsg:28992';

// Establish the connection
$client = Client::init($secret, $acceptCRS);
$lvbag = Lvbag::init($client);
```

### Adres uitgebreid

Based on given address data

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

