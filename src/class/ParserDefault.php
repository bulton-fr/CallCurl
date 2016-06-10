<?php

/**
 * @version 1.0
 * @author Vermeulen Maxime (bulton-fr) <bulton.fr@gmail.com>
 * @package bultonFr
 */

namespace bultonFr\CallCurl;

class ParserDefault implements \bultonFr\CallCurl\Parser
{

    /**
     * {@inheritdoc}
     */
    public function preFormatDatas(&$datas)
    {
        //Default parser: Nothing to do
    }

    /**
     * {@inheritdoc}
     */
    public function formatCallReturn(&$callReturn)
    {
        //Default parser: Nothing to do
    }

}
