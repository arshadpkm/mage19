<?php
/**
 * Created by PhpStorm.
 * User: RetailOn
 * Date: 2/3/15
 * Time: 8:52 PM
 */
class Retailon_Commission_Model_Resource_Seller_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('commission/seller');
    }
}