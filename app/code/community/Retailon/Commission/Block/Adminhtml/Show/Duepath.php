<?php

class Retailon_Commission_Block_Adminhtml_Show_Duepath extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
public function render(Varien_Object $row)
{
 $id_is= $row->getData('id');
 $coll = Mage::getSingleton('core/resource')->getConnection('core_read');
 $sql = "select due from seller_commission_calculate where id=$id_is";
  $res = $coll->fetchOne($sql);
  
                       $retailonex001=(string)$res;  
                        $retailonex002= strpos($retailonex001, ".", 0);
                        $retailonex003=substr($retailonex001,$retailonex002+1,2);
                      if($retailonex003=="00")
                       {
                        $res="0.00";
                       }
                      else
                       {     
  
                       $res1=(float)$res;
                       $res=number_format($res1,2);
                       }
                       return $res;
 
}
}