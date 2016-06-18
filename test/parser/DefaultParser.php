<?php

namespace bultonFr\CallCurl\Parser\test\unit;
use \atoum;

require_once(__DIR__.'/../../vendor/autoload.php');

class DefaultParser extends atoum
{
    public function testPreFormatDatas()
    {
        $this->newTestedInstance();
        
        $datas = '';
        $this->assert('preformat empty string data')
            ->given($this->testedInstance->preFormatDatas($datas))
            ->string($datas)
                ->isEqualTo('');
        
        $datas = 'format Datas';
        $this->assert('preformat string data')
            ->given($this->testedInstance->preFormatDatas($datas))
            ->string($datas)
                ->isEqualTo('format Datas');
        
        $datas = [];
        $this->assert('preformat empty array data')
            ->given($this->testedInstance->preFormatDatas($datas))
            ->array($datas)
                ->isEqualTo([]);
        
        $datas = ['test' => 123];
        $this->assert('preformat empty array data')
            ->given($this->testedInstance->preFormatDatas($datas))
            ->array($datas)
                ->isEqualTo(['test' => 123]);
    }
    
    public function testFormatCallReturn()
    {
        $this->newTestedInstance();
        
        $datas = '';
        $this->assert('preformat empty string data')
            ->given($this->testedInstance->formatCallReturn($datas))
            ->string($datas)
                ->isEqualTo('');
        
        $datas = 'format Datas';
        $this->assert('preformat string data')
            ->given($this->testedInstance->formatCallReturn($datas))
            ->string($datas)
                ->isEqualTo('format Datas');
        
        $datas = [];
        $this->assert('preformat empty array data')
            ->given($this->testedInstance->formatCallReturn($datas))
            ->array($datas)
                ->isEqualTo([]);
        
        $datas = ['test' => 123];
        $this->assert('preformat empty array data')
            ->given($this->testedInstance->formatCallReturn($datas))
            ->array($datas)
                ->isEqualTo(['test' => 123]);
    }
}