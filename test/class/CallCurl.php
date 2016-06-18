<?php

namespace bultonFr\CallCurl\test\unit;
use \atoum;

require_once(__DIR__.'/../../vendor/autoload.php');

class CallCurl extends atoum
{
    /**
     * @var $mock : Instance du mock pour la class CallCurl
     */
    protected $mock;

    /**
     * Instanciation de la class avant chaque méthode de test
     */
    public function beforeTestMethod($testMethod)
    {
        $this->mock = new MockCallCurl;
    }
    
    public function testCallCurl()
    {
        $nullParser = null;
        $jsonParser = new \bultonFr\CallCurl\Parser\Json;
        
        $this->assert('Test constructor default parameters')
            ->variable($this->mock->curl)
                ->isNotNull()
            ->object($this->mock->parserOutput)
                ->isInstanceOf('\bultonFr\CallCurl\Parser\DefaultParser')
            ->object($this->mock->parserInput)
                ->isInstanceOf('\bultonFr\CallCurl\Parser\DefaultParser');
        
        $this->mock = new MockCallCurl($jsonParser);
        $this->assert('Test constructor with json parser first parameter')
            ->variable($this->mock->curl)
                ->isNotNull()
            ->object($this->mock->parserOutput)
                ->isInstanceOf('\bultonFr\CallCurl\Parser\Json')
            ->object($this->mock->parserInput)
                ->isInstanceOf('\bultonFr\CallCurl\Parser\DefaultParser');
        
        $this->mock = new MockCallCurl($nullParser, $jsonParser);
        $this->assert('Test constructor with json parser second parameter')
            ->variable($this->mock->curl)
                ->isNotNull()
            ->object($this->mock->parserOutput)
                ->isInstanceOf('\bultonFr\CallCurl\Parser\DefaultParser')
            ->object($this->mock->parserInput)
                ->isInstanceOf('\bultonFr\CallCurl\Parser\Json');
        
        $this->mock = new MockCallCurl($jsonParser, $jsonParser);
        $this->assert('Test constructor with json parser all parameters')
            ->variable($this->mock->curl)
                ->isNotNull()
            ->object($this->mock->parserOutput)
                ->isInstanceOf('\bultonFr\CallCurl\Parser\Json')
            ->object($this->mock->parserInput)
                ->isInstanceOf('\bultonFr\CallCurl\Parser\Json');
    }
    
    /**
     * Not testable. Should be public and not extends for be testable... WTF !!
     */
    public function testCheckLib()
    {
        /*
        $this->assert('La lib php-curl existe')
            ->given($this->mock)
            ->if($this->function->function_exists = true)
            ->then
            ->function('function_exists')->wasCalled()->once()
            
            ->assert('La lib php-curl n\'existe pas')
            ->given($this->mock)
            ->if($this->function->function_exists = true)
            ->then
            ->exception(function() {
                $this->mock->checkLib();
            });
        */
    }
    
    public function testcheckParser()
    {
        $parser = null;
        $this->mock->checkParser($parser);
        $this->assert('DefaultParser used')
            ->object($parser)
                ->isInstanceOf('\bultonFr\CallCurl\Parser\DefaultParser');
        
        $mock = $this->mock;
        
        $this->assert('Parser use is not a object or null')
            ->exception(function() use ($mock)
            {
                $parser = true;
                $mock->checkParser($parser);
            })->hasMessage('Parser should be an object instance.');
        
        $this->assert('Parser used not implement interface')
            ->exception(function() use ($mock)
            {
                $parser = new FaultParser;
                $mock->checkParser($parser);
            })->hasMessage('Parser should implement \bultonFr\Parser interface.');
    }
    
    public function testSetUrl()
    {
        $this->assert('set string url')
            ->object($this->mock->setUrl('/test/'))
                ->isIdenticalTo($this->mock)
            ->string($this->mock->url)
                ->isEqualTo('/test/');
        
        $mock = $this->mock;
        $this->assert('set url with not a string')
            ->exception(function() use ($mock)
            {
                $mock->setUrl(123);
            })->hasMessage('Url send to CallCurl should be a string variable');
    }
    
    public function testGetUrl()
    {
        $this->assert('get default url')
            ->string($this->mock->getUrl())
                ->isEqualTo('');
        
        $this->mock->url = '/test/';
        $this->assert('get modified url')
            ->string($this->mock->getUrl())
                ->isEqualTo('/test/');
    }
    
    public function testSetDatas()
    {
        $testDatas = ['test1', 'test2'];
        
        $this->assert('set datas with a array')
            ->object($this->mock->setDatas($testDatas))
                ->isIdenticalTo($this->mock)
            ->array($this->mock->datas)
                ->isEqualTo($testDatas);
    }
    
    public function testGetDatas()
    {
        $this->assert('get default datas')
            ->string($this->mock->getDatas())
                ->isEqualTo('');
        
        $testDatas = ['test1', 'test2'];
        
        $this->mock->datas = $testDatas;
        $this->assert('get modified datas')
            ->array($this->mock->getDatas())
                ->isEqualTo($testDatas);
    }
    
    public function testSetHttpMethod()
    {
        $this->assert('set http method')
            ->object($this->mock->setHttpMethod('get'))
                ->isIdenticalTo($this->mock)
            ->string($this->mock->httpMethod)
                ->isEqualTo('GET');
        
        $mock = $this->mock;
        $this->assert('set http method with not a string')
            ->exception(function() use ($mock)
            {
                $mock->setHttpMethod(123);
            })->hasMessage('HTTP method send to CallCurl should be a string variable');
    }
    
    public function testSetDebug()
    {
        $this->assert('set debug')
            ->object($this->mock->setDebug(true))
                ->isIdenticalTo($this->mock)
            ->boolean($this->mock->debug)
                ->isEqualTo(true);
        
        $mock = $this->mock;
        $this->assert('set debug with not a boolean')
            ->exception(function() use ($mock)
            {
                $mock->setDebug(123);
            })->hasMessage('Debug status send to CallCurl should be a boolean variable');
    }
    
    public function testSetCheckSSL()
    {
        $this->assert('set check ssl')
            ->object($this->mock->setCheckSSL(true))
                ->isIdenticalTo($this->mock)
            ->boolean($this->mock->checkSSL)
                ->isEqualTo(true);
        
        $mock = $this->mock;
        $this->assert('set check ssl with not a boolean')
            ->exception(function() use ($mock)
            {
                $mock->setCheckSSL(123);
            })->hasMessage('CheckSSL status send to CallCurl should be a boolean variable');
    }
    
    public function testGetCurlReturnDatas()
    {
        $this->assert('get default CurlReturnDatas')
            ->variable($this->mock->getCurlReturnDatas())
                ->isNull();
        
        $this->mock->returnDatas = 'TestMock';
        $this->assert('get modified CurlReturnDatas')
            ->string($this->mock->getCurlReturnDatas())
                ->isEqualTo('TestMock');
    }
    
    public function testGetCurlCallInfos()
    {
        $this->assert('get default CurlCallInfos')
            ->variable($this->mock->getCurlCallInfos())
                ->isNull();
        
        $this->mock->curlCallInfos = [];
        $this->assert('get modified CurlCallInfos')
            ->array($this->mock->getCurlCallInfos())
                ->isEqualTo([]);
    }
    
    public function testRunCall()
    {
        $this->assert('runCall')
            ->string($this->mock->runCall())
                ->isEqualTo('TestMock');
    }
    
    public function testCurlSetOptions()
    {
        $this->assert('curlSetOptions default return')
            ->array($this->mock->curlSetOptions())
                ->isEqualTo([
                    CURLOPT_URL            => '',
                    CURLOPT_RETURNTRANSFER => true
                ]);
        
        $this->mock->debug    = true;
        $this->mock->checkSSL = true;
        $this->assert('curlSetOptions return with debug')
            ->array($this->mock->curlSetOptions())
                ->isEqualTo([
                    CURLOPT_URL            => '',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER         => true,
                    CURLOPT_VERBOSE        => true,
                    CURLINFO_HEADER_OUT    => true,
                ]);
        
        $this->mock->debug    = false;
        $this->mock->checkSSL = false;
        $this->assert('curlSetOptions return with no check ssl')
            ->array($this->mock->curlSetOptions())
                ->isEqualTo([
                    CURLOPT_URL            => '',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false
                ]);
        
        $this->mock->debug    = true;
        $this->mock->checkSSL = false;
        $this->assert('curlSetOptions return with debug and no check ssl')
            ->array($this->mock->curlSetOptions())
                ->isEqualTo([
                    CURLOPT_URL            => '',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER         => true,
                    CURLOPT_VERBOSE        => true,
                    CURLINFO_HEADER_OUT    => true,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false
                ]);
    }
    
    public function testCurlOptionsAddDatas()
    {
        $options = [CURLOPT_URL => ''];
        $this->assert('curlOptionsAddDatas without datas')
            ->variable($this->mock->curlOptionsAddDatas($options))
                ->isNull()
            ->array($options)
                ->isEqualTo([CURLOPT_URL => '']);
        
        $options                = [CURLOPT_URL => ''];
        $this->mock->httpMethod = 'GET';
        $this->mock->datas      = 'testDatas';
        $this->assert('curlOptionsAddDatas with simple datas for GET method')
            ->variable($this->mock->curlOptionsAddDatas($options))
                ->isNull()
            ->array($options)
                ->isEqualTo([CURLOPT_URL => '?testDatas']);
        
        $options                = [CURLOPT_URL => ''];
        $this->mock->httpMethod = 'GET';
        $this->mock->datas      = ['testDatas' => 1];
        $this->assert('curlOptionsAddDatas with array datas for GET method')
            ->variable($this->mock->curlOptionsAddDatas($options))
                ->isNull()
            ->array($options)
                ->isEqualTo([CURLOPT_URL => '?testDatas=1']);
        
        $options                = [CURLOPT_URL => '/test/'];
        $this->mock->httpMethod = 'GET';
        $this->mock->url        = '/test/';
        $this->mock->datas      = ['testDatas' => 1];
        $this->assert('curlOptionsAddDatas with url and array datas for GET method')
            ->variable($this->mock->curlOptionsAddDatas($options))
                ->isNull()
            ->array($options)
                ->isEqualTo([CURLOPT_URL => '/test/?testDatas=1']);
        
        $options                = [CURLOPT_URL => '/test/?test=1'];
        $this->mock->httpMethod = 'GET';
        $this->mock->url        = '/test/?test=1';
        $this->mock->datas      = ['testDatas' => 1];
        $this->assert('curlOptionsAddDatas with a url who have already parameters and array datas for GET method')
            ->variable($this->mock->curlOptionsAddDatas($options))
                ->isNull()
            ->array($options)
                ->isEqualTo([CURLOPT_URL => '/test/?test=1&testDatas=1']);
        
        $options                = [];
        $this->mock->httpMethod = 'POST';
        $this->mock->datas      = 'testDatas';
        $this->assert('curlOptionsAddDatas with simple datas for POST method')
            ->variable($this->mock->curlOptionsAddDatas($options))
                ->isNull()
            ->array($options)
                ->isEqualTo([
                    CURLOPT_POST       => true,
                    CURLOPT_POSTFIELDS => 'testDatas'
                ]);
        
        $options                = [];
        $this->mock->httpMethod = 'POST';
        $this->mock->datas      = ['testDatas' => 1];
        $this->assert('curlOptionsAddDatas with array datas for POST method')
            ->variable($this->mock->curlOptionsAddDatas($options))
                ->isNull()
            ->array($options)
                ->isEqualTo([
                    CURLOPT_POST       => true,
                    CURLOPT_POSTFIELDS => ['testDatas' => 1]
                ]);
    }
    
    public function testGetFromCurl()
    {
        $this->mock->getFromCurl();
        
        $this->assert('test getFromCurl Mocked')
            ->variable($this->mock->curl)
                ->isNull()
            ->string($this->mock->returnDatas)
                ->isEqualTo('TestMock')
            ->array($this->mock->curlCallInfos)
                ->isEqualTo([]);
    }
}

/**
 * Mock de la class à tester
 */
class MockCallCurl extends \bultonFr\CallCurl\CallCurl
{
    /**
     * Accesseur get
     */
    public function __get($name)
    {
        return $this->$name;
    }
    
    /**
     * Accesseur set
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function checkLib()
    {
        return parent::checkLib();
    }
    
    public function checkParser(&$parser)
    {
        return parent::checkParser($parser);
    }
    
    public function runCall()
    {
        //For use curlCall from this class
        return parent::runCall();
    }
    
    public function curlSetOptions()
    {
        return parent::curlSetOptions();
    }
    
    public function curlOptionsAddDatas(&$options)
    {
        return parent::curlOptionsAddDatas($options);
    }
    
    public function getFromCurl()
    {
        //return parent::curlCall();
        
        $this->curl          = null; //curl_close()
        $this->returnDatas   = 'TestMock'; //curl_exec()
        $this->curlCallInfos = []; //curl_getinfo()
    }
}

class FaultParser
{
    
}
