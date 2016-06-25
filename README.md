# CallCurl
Lib to simply use curl with PHP

[![Build Status](https://travis-ci.org/bulton-fr/call-curl.svg?branch=master)](https://travis-ci.org/bulton-fr/call-curl) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bulton-fr/call-curl/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/bulton-fr/call-curl/?branch=1.0) [![Coverage Status](https://coveralls.io/repos/github/bulton-fr/call-curl/badge.svg?branch=master)](https://coveralls.io/github/bulton-fr/call-curl?branch=master)

## Install with composer

Download composer
```
$ curl -s https://getcomposer.org/installer | php
```

Add call-curl repository to you composer.json
```json
{
    "require": {
        "bulton-fr/call-curl": "@stable"
    }
}
```

Execute the command
```
$ php composer.phar install
```

## Use in your code
### Default parser : No parse data send and receive
```php
$curl = new \bultonFr\CallCurl\CallCurl;
$curl->setUrl('http://www.github.com');

$dataReceive = $curl->runCall();
$dataHeaders = $curl->getCurlCallInfos();
```

### With the Json parser
```php
$jsonParser = new \bultonFr\CallCurl\Parser\Json;
$curl       = new \bultonFr\CallCurl\CallCurl($jsonParser, $jsonParser);
$curl->setUrl('http://www.github.com/api');

$dataReceive = $curl->runCall();
$dataHeaders = $curl->getCurlCallInfos();
```

More explications on [wiki](https://github.com/bulton-fr/call-curl/wiki)
