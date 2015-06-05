<?php
/**
* Copyright © Pulsestorm LLC: All rights reserved
*/

class Vmrproducts_Commercebug_Model_Resource_Mysql4_Setup extends Mage_Core_Model_Resource_Setup
{
    public function getShim()
    {
        $shim = Vmrproducts_Commercebug_Model_Shim::getInstance();
        return $shim;
    }
}