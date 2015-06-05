<?php
class Retailon_Storeconf_Model_Mysql4_Storeconf extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("storeconf/storeconf", "id");
    }
}