<?php
class Retailon_Commission_Block_Adminhtml_Test_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
    public function render(Varien_Object $row)
    { 
     $store_id_is = $row->getData('store_id');
     $resource = Mage::getSingleton('core/resource');
     $readConnection = $resource->getConnection('core_read');
     $info="SELECT total_sales,total_commission,due,total_paid FROM seller_commission_show where store_id=$store_id_is ";
     $result=$readConnection->fetchAll($info);
      foreach($result as $value)
       {
       $total_sales=$value['total_sales'];
       $total_commission=$value['total_commission'];
       $total_due=$value['due'];
       $total_paid=$value['total_paid'];
       }
   
    if($total_sales==0)
     return '<div style="font-weight:bold;background:#DDDD;border-radius:8px;width:100%"></div>';
    if(($total_sales-$total_commission)==$total_paid || ($total_due <= 0.01))
      return '<div style="font-weight:bold;background:#2DD933;border-radius:8px;width:100%"> PAID</div>';
    else
     return '<div style="font-weight:bold;background:#EF4F33;border-radius:8px;width:100%"> PENDING</div>';
   
    
    }
    
}
?>