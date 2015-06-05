<?php

class Retailon_Commission_Block_Adminhtml_Show_TotalCommissionpath extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
public function render(Varien_Object $row)
{
 $id_is= $row->getData('id');
 $coll = Mage::getSingleton('core/resource')->getConnection('core_read');
 $sql = "select total_commission from seller_commission_calculate where id=$id_is";
 //$sql = "select due from seller_commission_calculate where id=$id_is ORDER BY id DESC LIMIT 1";
 
  $res = $coll->fetchOne($sql);
  
  $res1=(float)$res;
  $res=number_format($res1,2);
 return $res;
 
}
}