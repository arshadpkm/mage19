<?php

class Retailon_Commission_Block_Adminhtml_Test_Commpath extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
public function render(Varien_Object $row)
{
 $seller_id_is= $row->getData('seller_id');$comm = $row->getData('commission_rate');
 $coll = Mage::getSingleton('core/resource')->getConnection('core_read');
 $sql = "select rate_type from seller_commission_show where seller_id=$seller_id_is and rate_type='%'";
  $res = $coll->fetchOne($sql);
 return $comm.$res;
 
}
}