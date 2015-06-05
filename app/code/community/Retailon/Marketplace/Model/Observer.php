<?php
/**
 * Created by PhpStorm.
 * User: Arshad M <me@arshu.in>
 * Date: 6/3/2015
 * Time: 7:46 PM
 */
class Retailon_Marketplace_Model_Observer {
    protected $_roleId = null;
    public function adminUserSaveAfter($observer){
        $userID = $observer->getEvent()->getObject()->getUserId();
        $model = Mage::getModel("marketplace/marketplace")->load($userID,'mage_user_id');
        $this->_roleId = $observer->getEvent()->getObject()->getData('roles')[0];
        if($model->getMageUserId()){
            return $this;
        }
        if(!$this->_isVendor()){
            return $this;
        }
        $model->setMageUserId($userID);
        $model->save();
    }
    /*
     * Check is vendor or admin
     */
    protected function _isVendor(){
        if ( $this->_roleId == Mage::getStoreConfig( 'marketplace/marketplace/vendors_role' ) )
            return true;
        return false;
    }
    /*
     * To update the sales commision
     */
    public function updateSalesCommission(){
        /* Format our dates */

        $fromDate = date('Y-m-d 00:00:00');
        $toDate = date('Y-m-d 24:00:00');

        /* Get the collection */
        $orders = Mage::getModel('sales/order')->getCollection()
            ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
            ->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE))
        ;
        $totals[] = array();
        foreach($orders as $order){
            $order->getData('subtotal');
            $userId = Mage::getModel('marketplace/vendor')->load($order->getIncrementId(),'mage_order_id')->getUserId();
            if($userId){
                $totals[$userId] = $totals[$userId] + $order->getData('subtotal');
            }
        }
        foreach($totals as $key => $value){
            if($key){
                $model = Mage::getModel('marketplace/commission')->load($key,'mage_user_id');
                $vendorModel = Mage::getModel('marketplace/marketplace')->load($key,'mage_user_id');
                if($model->getTotalSales()){
                    $model->setModifiedDate(date('Y-m-d'));
                    $model->setTotalSales($model->getTotalSales() + $value);
                    $commission = $model->getTotalCommission();
                    $cType = $vendorModel->getCommissionType();
                    $cValue = $vendorModel->getCommissionAmount();
                    if($cType){
                        $model->setTotalCommission($commission + $cValue);
                        $model->setDue($model->getDue() + $value - $cValue);
                    }else{
                        $com = ( $value / 100 ) * $cValue;
                        $model->setTotalCommission($commission + $com);
                        $model->setDue($model->getDue() + $value - $com);
                    }
                }else{
                    $model = Mage::getModel('marketplace/commission');
                    $model->setMageUserId($key);
                    $model->setCreatedAt(date('Y-m-d'));
                    $model->setTotalSales($model->getTotalSales() + $value);
                    $commission = $model->getTotalCommission();
                    $cType = $vendorModel->getCommissionType();
                    $cValue = $vendorModel->getCommissionAmount();
                    if($cType){
                        $model->setTotalCommission($commission + $cValue);
                        $model->setDue($model->getDue() + $value - $cValue);
                    }else{
                        $com = ( $value / 100 ) * $cValue;
                        $model->setTotalCommission($commission + $com);
                        $model->setDue($model->getDue() + $value - $com);
                    }
                }
                $model->save();
            }
        }
    }
}