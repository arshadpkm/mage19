<?php
/**
 * Created by PhpStorm.
 * User: Arshad M <me@arshu.in>
 * Date: 5/29/2015
 * Time: 5:01 PM
 */

class Retailon_Marketplace_OrderController extends Mage_Core_Controller_Front_Action {

    public function cancelAction(){
        if ($order = $this->_initOrder()) {
            try {
                $order->cancel()
                    ->save();
                $this->_getSession()->addSuccess(
                    $this->__('The order has been cancelled.')
                );
                Mage::dispatchEvent('marketplace_order_after_cancel',array('order' => $order));
            }
            catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addError($this->__('The order has not been cancelled.'));
                Mage::logException($e);
            }
            $this->_redirect('sales/order/view', array('order_id' => $order->getId()));
        }
    }

    protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($id);
        if (!$order->getId()) {
            $this->_getSession()->addError($this->__('This order no longer exists.'));
            $this->_redirect('sales/order/view',array('order_id'=>$id));
            return false;
        }
        return $order;
    }

    protected function _getSession()
    {
        return Mage::getSingleton('core/session');
    }
}