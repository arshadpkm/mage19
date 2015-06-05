<?php
/**
 * Created by PhpStorm.
 * User: Arshad M <me@arshu.in>
 * Date: 5/26/2015
 * Time: 3:08 PM
 */ 
class Retailon_Marketplace_Model_Vendor extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('marketplace/vendor');
    }
}