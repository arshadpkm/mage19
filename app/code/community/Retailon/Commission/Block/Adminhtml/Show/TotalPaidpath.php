<?php

class Retailon_Commission_Block_Adminhtml_Show_TotalPaidpath extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
public function render(Varien_Object $row)
{
 $id_is= $row->getData('id');
 $coll = Mage::getSingleton('core/resource')->getConnection('core_read');
 $sql = "select total_paid from seller_commission_calculate where id=$id_is";
  $res = $coll->fetchOne($sql);
  
  $res1=(float)$res;
  $res=number_format($res1,2);
 return $res;
 
}
}