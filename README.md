# CallCurl
Lib to simply use curl with PHP


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
