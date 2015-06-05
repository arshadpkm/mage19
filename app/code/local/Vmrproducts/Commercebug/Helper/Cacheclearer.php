<?php
/**
* Copyright © Pulsestorm LLC: All rights reserved
*/

class Vmrproducts_Commercebug_Helper_Cacheclearer
{
    public function clearCache()
    {			
        $shim = $this->getShim()->cleanCache();     
    }
    public function getShim()
    {
        $shim = Vmrproducts_Commercebug_Model_Shim::getInstance();
        return $shim;
    }    
}