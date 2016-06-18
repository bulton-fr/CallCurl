<?php

/**
 * @version 1.0
 * @author Vermeulen Maxime (bulton-fr) <bulton.fr@gmail.com>
 * @package bultonFr
 */

namespace bultonFr\CallCurl\Parser;

use \Exception;

class Json implements \bultonFr\CallCurl\Parser
{

    /**
     * {@inheritdoc}
     */
    public function preFormatDatas(&$datas)
    {
        $datas = json_encode($datas);
    }

    /**
     * {@inheritdoc}
     */
    public function formatCallReturn(&$callReturn)
    {
        $callReturn = json_decode($callReturn);
        
        if($callReturn === null) {
            throw new Exception(json_last_error_msg());
        }
    }

}
