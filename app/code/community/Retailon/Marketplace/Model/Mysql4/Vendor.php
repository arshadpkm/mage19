<?php
/**
 * Created by PhpStorm.
 * User: arshad
 * Date: 5/26/2015
 * Time: 3:08 PM
 */ 
class Retailon_Marketplace_Model_Mysql4_Vendor extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('marketplace/retailon_vendor_orders', 'vendor_order_id');
    }

}