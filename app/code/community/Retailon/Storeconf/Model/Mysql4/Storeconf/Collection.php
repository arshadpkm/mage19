<?php
    class Retailon_Storeconf_Model_Mysql4_Storeconf_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
    {

		public function _construct()
        {
			$this->_init("storeconf/storeconf");
		}
    }
