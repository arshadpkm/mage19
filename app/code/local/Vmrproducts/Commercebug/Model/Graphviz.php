<?php
/**
* Copyright © Pulsestorm LLC: All rights reserved
*/
class Vmrproducts_Commercebug_Model_Graphviz
{
    public function capture()
    {    
        $collector  = new Vmrproducts_Commercebug_Model_Collectorgraphviz; 
        $o = new stdClass();
        $o->dot = Vmrproducts_Commercebug_Model_Observer_Dot::renderGraph();
        $collector->collectInformation($o);
    }
    
    public function getShim()
    {
        $shim = Vmrproducts_Commercebug_Model_Shim::getInstance();        
        return $shim;
    }    
}