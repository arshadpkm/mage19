<?php
class Retailon_Commission_Model_Resource_Sellershow extends Mage_Core_Model_Resource_Db_Abstract {
    protected function _construct() {
        $this->_init( 'commission/sellershow', 'id' );
    }
}
?>