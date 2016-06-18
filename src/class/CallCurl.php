<?php

/**
 * @version 1.0
 * @author Vermeulen Maxime (bulton-fr) <bulton.fr@gmail.com>
 * @package bultonFr
 */

namespace bultonFr\CallCurl;

use \Exception;
use \bultonFr\CallCurl\Parser as ParserInterface;
use \bultonFr\CallCurl\Parser\DefaultParser;

class CallCurl
{
    /**
     * @var resource $curl Curl resource
     */
    protected $curl = null;

    /**
     * @var Object $parserInput PHP Class used for parse data before call
     */
    protected $parserOutput = null;

    /**
     * @var Object $parserOutput PHP Class used for parse data after call
     */
    protected $parserInput = null;

    /**
     * @var string $url The url to call with curl
     */
    protected $url = '';

    /**
     * @var mixed $datas Datas to send with curl
     */
    protected $datas = '';

    /**
     * @var string $httpMethod The HTTP method to use for curl call
     */
    protected $httpMethod = 'GET';

    /**
     * @var boolean $debug Ask to curl more datas to return for help debug 
     */
    protected $debug = false;

    /**
     * @var boolean $checkSSL If curl doing check SSL certificate
     */
    protected $checkSSL = true;

    /**
     * @var mixed $returnDatas : Datas return by curl call
     */
    protected $returnDatas;

    /**
     * @var boolean|array $curlCallInfos : Informations returned by curl
     */
    protected $curlCallInfos;

    /**
     * Constructor
     * 
     * Check dependancy
     * Initialise curl connection
     * Check parsers
     */
    public function __construct(&$parserOutput = null, &$parserInput = null)
    {
        //Check Dependancy
        $this->checkLib();

        //Initialise curl
        $this->curl = curl_init();

        //Check and initialise Parsers
        $this->checkParser($parserOutput);
        $this->checkParser($parserInput);
        
        $this->parserOutput = $parserOutput;
        $this->parserInput  = $parserInput;
    }

    /**
     * Check if all php librairie required is active
     * 
     * @throws Exception
     * 
     * @return void
     */
    protected function checkLib()
    {
        //Check curl php extension
        if(!function_exists('curl_init')) {
            throw new Exception('Please install or activate php-curl extension for use CallCurl plugin.');
        }
    }

    /**
     * Check if datas parser is a object and implement parser interface
     * 
     * @param mixed &$parser Parser to use
     * 
     * @throws Exception If error is find on parser definition
     */
    protected function checkParser(&$parser)
    {
        if(is_null($parser)) {
            $parser = new DefaultParser;
        }

        if(!is_object($parser)) {
            throw new Exception('Parser should be an object instance.');
        }

        if(!($parser instanceof ParserInterface)) {
            throw new Exception('Parser should implement \bultonFr\Parser interface.');
        }
    }

    /**
     * Set url to call
     * 
     * @param string $url : Url to call
     * 
     * @return \bultonFr\CallCurl : Current class instance
     * 
     * @throws Exception : If parameter is not a string
     */
    public function setUrl($url)
    {
        if(!is_string($url)) {
            throw new Exception('Url send to CallCurl should be a string variable');
        }

        $this->url = $url;

        return $this;
    }

    /**
     * Getter to url to call
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set datas to send with curl
     * 
     * @param mixed $datas
     * 
     * @return \bultonFr\CallCurl : Current class instance
     */
    public function setDatas($datas)
    {
        $this->datas = $datas;

        return $this;
    }

    /**
     * Getter to datas send with curl
     * 
     * @return mixed
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * Set HTTP method to use to call
     * ex: GET, POST, PUT, DELETE etc
     * 
     * @param string $method : The HTTP method to use
     * 
     * @return \bultonFr\CallCurl : Current class instance
     * 
     * @throws Exception : If parameter is not a string
     */
    public function setHttpMethod($method)
    {
        if(!is_string($method)) {
            throw new Exception('HTTP method send to CallCurl should be a string variable');
        }

        $this->httpMethod = strtoupper($method);

        return $this;
    }

    /**
     * Set debug mode.
     * Curl call return more informations to help
     * 
     * @param boolean $debug : Debug mode status
     * 
     * @return \bultonFr\CallCurl : Current class instance
     * 
     * @throws Exception : If parameter is not a boolean
     */
    public function setDebug($debug)
    {
        if(!is_bool($debug)) {
            throw new Exception('Debug status send to CallCurl should be a boolean variable');
        }

        $this->debug = $debug;

        return $this;
    }

    /**
     * Set if curl check SSL certificate
     * 
     * @param type $checkSSL : check SSL status
     * 
     * @return \bultonFr\CallCurl : Current class instance
     * 
     * @throws Exception : If parameter is not a boolean
     */
    public function setCheckSSL($checkSSL)
    {
        if(!is_bool($checkSSL)) {
            throw new Exception('CheckSSL status send to CallCurl should be a boolean variable');
        }

        $this->checkSSL = $checkSSL;

        return $this;
    }

    /**
     * Get curl returned datas after parser formating
     * 
     * @return mixed
     */
    public function getCurlReturnDatas()
    {
        return $this->returnDatas;
    }

    /**
     * Get curl call information
     * 
     * @see http://php.net/manual/fr/function.curl-getinfo.php
     * 
     * @return boolean|array : false if error. else, array to information
     */
    public function getCurlCallInfos()
    {
        return $this->curlCallInfos;
    }

    /**
     * Run curl call stack
     * * Formating datas before call
     * * Generating curl options array
     * * Run call
     * * Formating datas returned by curl
     * 
     * @return mixed Datas returned by curl
     */
    public function runCall()
    {
        $this->parserOutput->preFormatDatas($this->datas);

        $options = $this->curlSetOptions();
        curl_setopt_array($this->curl, $options);

        $this->curlCall();
        $this->parserInput->formatCallReturn($this->returnDatas);

        return $this->returnDatas;
    }

    /**
     * Define curl options array
     * 
     * @return array : Options array to curl call
     */
    protected function curlSetOptions()
    {
        $options = [
            CURLOPT_URL            => $this->url,
            CURLOPT_RETURNTRANSFER => true
        ];

        if($this->httpMethod === 'GET') {
            $datasUrl = urlencode($this->datas);

            if(strpos($this->url, '?') !== false) {
                $datasUrl = '&'.$datasUrl;
            }
            else {
                $datasUrl = '?'.$datasUrl;
            }

            $options[CURLOPT_URL] .= $datasUrl;
        }
        elseif($this->httpMethod === 'POST') {
            $options[CURLOPT_POST]       = true;
            $options[CURLOPT_POSTFIELDS] = $this->datas;
        }
        //@TODO : Other http status

        if($this->debug === true) {
            $options[CURLOPT_HEADER]      = true;
            $options[CURLOPT_VERBOSE]     = true;
            $options[CURLINFO_HEADER_OUT] = true;
        }

        if($this->checkSSL === false) {
            $options[CURLOPT_SSL_VERIFYHOST] = false;
            $options[CURLOPT_SSL_VERIFYPEER] = false;
        }

        return $options;
    }

    /**
     * Run curl call and get informations about call
     * 
     * @return void
     */
    protected function curlCall()
    {
        $this->returnDatas   = curl_exec($this->curl);
        $this->curlCallInfos = curl_getinfo($this->curl);

        curl_close($this->curl);
    }
}
