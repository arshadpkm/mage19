<?php
/**
 * Created by PhpStorm.
 * User: arshad
 * Date: 6/4/2015
 * Time: 5:31 PM
 */

class Retailon_Marketplace_Block_Adminhtml_Commission_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
    public function render(Varien_Object $row)
    {
        $status = $row->getData('status');
        if(!$status)
            return '<div style="font-weight:bold;background:#DDDD;border-radius:8px;width:100%"></div>';
        if($status == 2)
            return '<div style="font-weight:bold;background:#2DD933;border-radius:8px;width:100%"> PAID</div>';
        else
            return '<div style="font-weight:bold;background:#EF4F33;border-radius:8px;width:100%"> PENDING</div>';
    }
}