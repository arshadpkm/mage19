<?php
/**
 * Created by PhpStorm.
 * User: Arshad <me@arshu.in>
 * Date: 5/26/2015
 * Time: 3:08 PM
 */
class Retailon_Marketplace_Model_Mysql4_Marketplaceproducts_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
	public function _construct(){
		$this->_init( 'marketplace/marketplaceproducts' );
	}
}