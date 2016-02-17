gateway
======

> gateway - [php](http://php.net) library

## Install

Via Composer

```sh
composer require g4/gateway
```

## Usage

```php

use G4\Gateway\Options;
use G4\Gateway\Http;

$options = new Options();
$options
    ->addHeader('Accept', 'application/json')   // optional
    ->setTimeout(30)                            // optional
    ->setSslVerifyPeer(true);                   // optional
    
$http = new Http('http://api.url', $options)
$http
    ->setServiceName('maps');                   // optional

$response = $http->get(['id' => 123]);          // post(), put(), delete()

echo $response->getCode();
echo $response->getBody();

```

## Development

### Install dependencies

    $ make install

### Run tests

    $ make unit-tests

## License

(The MIT License)
see LICENSE file for details...
