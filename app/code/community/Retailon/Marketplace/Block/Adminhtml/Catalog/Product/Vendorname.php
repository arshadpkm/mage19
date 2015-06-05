<?php
/**
 * Created by PhpStorm.
 * User: Arshad M <me@arshu.in>
 * Date: 6/2/2015
 * Time: 6:14 PM
 */

class Retailon_Marketplace_Block_Adminhtml_Catalog_Product_Vendorname extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input{
    public function render(Varien_Object $row){
        $id = $row->getData('entity_id');
        $vendor = Mage::getModel( 'marketplace/marketplaceproducts' )
            ->getCollection()
            ->addFieldToSelect( 'user_id' )
            ->addFieldToFilter( 'product_id', $id )
            ->getFirstItem();
        $user = Mage::getModel( 'admin/user' )->load($vendor->getUserId());
        return $user->getFirstname().' '.$user->getLastname();
    }
}