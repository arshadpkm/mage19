<?php
class Retailon_Commission_Model_Resource_Commission extends Mage_Core_Model_Resource_Db_Abstract {
    protected function _construct() {
        $this->_init( 'commission/commission', 'comm_id' );
    }
}