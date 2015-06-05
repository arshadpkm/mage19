<?php
/**
 * Created by PhpStorm.
 * User: arshad
 * Date: 6/4/2015
 * Time: 3:21 PM
 */ 
class Retailon_Marketplace_Model_Mysql4_Commission_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('marketplace/commission');
    }

}