<?php
/**
* Copyright © Pulsestorm LLC: All rights reserved
*/
class Vmrproducts_Commercebug_Model_Crossareaajax_Togglecblogging extends Vmrproducts_Commercebug_Model_Crossareaajax
{
    public function handleRequest()
    {
        $session = $this->_getSessionObject(); 
        $c = $session->getData(Vmrproducts_Commercebug_Model_Observer::CB_LOGGING_ON);
        $c = $c == 'on' ? 'off' : 'on';        
        $session->setData(Vmrproducts_Commercebug_Model_Observer::CB_LOGGING_ON,$c);
        $this->endWithHtml('Commerce Bug Logging ' . ucwords($c) .'');        
    }
}