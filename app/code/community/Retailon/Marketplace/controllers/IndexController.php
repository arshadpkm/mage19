<?php
/**
 * Created by PhpStorm.
 * User: Arshad M <me@arshu.in>
 * Date: 5/27/2015
 * Time: 12:12 PM
 */

class Retailon_Marketplace_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction(){
        $singleOrder = Mage::getModel('marketplace/singleorder');
        $singleOrder->setCustomer(140);
        $singleOrder->setShippingMethod('flatrate_flatrate');
        $singleOrder->setPaymentMethod('cashondelivery');
        $products = array(
            array(
                'product' => 906,
                'qty' => 2
            )
        );
        $singleOrder->createOrder($products);
        echo 'done';
    }
    public function comAction(){
        /* Format our dates */

        $fromDate = date('Y-m-d 00:00:00');
        $toDate = date('Y-m-d 24:00:00');

        /* Get the collection */
        $orders = Mage::getModel('sales/order')->getCollection()
          //  ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
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