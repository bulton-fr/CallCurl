<?php

/**
 * @version 1.0
 * @author Vermeulen Maxime (bulton-fr) <bulton.fr@gmail.com>
 * @package bultonFr
 */

namespace bultonFr\CallCurl;

interface Parser
{
    /**
     * Used to format data before call
     * 
     * @param mixed &$datas : Datas to format
     */
    public function preFormatDatas(&$datas);
    
    /**
     * Used to format data return by curl call
     * 
     * @param mixed &$callReturn : Datas to format
     */
    public function formatCallReturn(&$callReturn);
}
