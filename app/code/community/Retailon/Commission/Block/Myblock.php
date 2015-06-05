<?php
class Retailon_Commission_Block_Myblock extends Mage_Core_Block_Template
{
    public function showcomm()
    {
    $seller_id_value = $this->getRequest()->getParam('seller_id');
     return $seller_id_value;
    }
}
?>