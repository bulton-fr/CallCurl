<?php

namespace bultonFr\CallCurl\Parser\test\unit;
use \atoum;

require_once(__DIR__.'/../../vendor/autoload.php');

class Json extends atoum
{
    public function testPreFormatDatas()
    {
        $this->newTestedInstance();
        
        $datas = '';
        $this->assert('preformat empty string data')
            ->given($this->testedInstance->preFormatDatas($datas))
            ->string($datas)
                ->isEqualTo('""');
        
        $datas = 'format Datas';
        $this->assert('preformat string data')
            ->given($this->testedInstance->preFormatDatas($datas))
            ->string($datas)
                ->isEqualTo('"format Datas"');
        
        $datas = [];
        $this->assert('preformat empty array data')
            ->given($this->testedInstance->preFormatDatas($datas))
            ->string($datas)
                ->isEqualTo('[]');
        
        $datas = ['test' => 123];
        $this->assert('preformat array with data')
            ->given($this->testedInstance->preFormatDatas($datas))
            ->string($datas)
                ->isEqualTo('{"test":123}');
    }
    
    public function testFormatCallReturn()
    {
        $this->newTestedInstance();
        $instance = $this->testedInstance;
        
        $this->assert('preformat empty string data')
            ->exception(function() use ($instance)
            {
                $datas = '';
                $this->testedInstance->formatCallReturn($datas);
            });//->hasMessage('Syntax error'); PHP7.x msg != PHP 5.x msg
        
        $this->assert('preformat string data')
            ->exception(function() use ($instance)
            {
                $datas = 'format Datas';
                $this->testedInstance->formatCallReturn($datas);
            });//->hasMessage('Syntax error'); PHP7.x msg != PHP 5.x msg
        
        $datas = '[]';
        $this->assert('preformat empty array data')
            ->given($this->testedInstance->formatCallReturn($datas))
            ->array($datas)
                ->isEqualTo([]);
        
        $datas = '{"test":123}';
        $expected = new \stdClass;
        $expected->test = 123;
        
        $this->assert('preformat array with data')
            ->given($this->testedInstance->formatCallReturn($datas))
            ->object($datas)
                ->isEqualTo($expected);
    }
}