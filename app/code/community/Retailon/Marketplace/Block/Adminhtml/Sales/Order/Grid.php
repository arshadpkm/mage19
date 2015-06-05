<?php
/**
 * Created by PhpStorm.
 * User: Arshad M <me@arshu.in>
 * Date: 5/28/2015
 * Time: 5:53 PM
 */ 
class Retailon_Marketplace_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid {

    public function setCollection($collection)
    {
        if($this->_isVendor())
            $collection->addFieldToFilter('increment_id',$this->_getVendorOrderIds());
        parent::setCollection($collection);
    }

//    protected function _prepareCollection()
//    {
//        if(!$this->_isVendor())
//            return parent::_prepareCollection();
//        $collection = Mage::getResourceModel($this->_getCollectionClass());
//        $collection->addFieldToFilter('increment_id',$this->_getVendorOrderIds());
//        $this->setCollection($collection);
//        return         parent::_prepareCollection();
//
//        return $this;
//    }
    /*
     * Get the vendor order ids
     * @param vendor id
     * @return oder ids
     */
    protected function _getVendorOrderIds(){
        $productIds = array();
        $vendor = Mage::getModel('marketplace/vendor')
            ->getCollection()
            ->addFieldToFilter('user_id',$this->_getVendorId());
        foreach($vendor as $vendorOrder){
            $productIds[] = $vendorOrder->getMageOrderId();
        }
        return $productIds;
    }

    /*
     * Get current user Id
     */
    protected function _getVendorId(){
        return $this->_getVendor()->getUserId();
    }

    /*
     * Get current user
     */
    protected function _getVendor(){
        return Mage::getSingleton( 'admin/session' )->getUser();
    }

    /*
     * Check is vendor or admin
     */
    protected function _isVendor(){
        if ( $this->_getVendor()->getRole()->getRoleId() == Mage::getStoreConfig( 'marketplace/marketplace/vendors_role' ) )
            return true;
        return false;
    }
}