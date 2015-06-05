<?php
/**
 * Created by PhpStorm.
 * User: arshad
 * Date: 5/29/2015
 * Time: 12:54 PM
 */ 
class Retailon_Marketplace_Block_Sales_Order_View extends Mage_Sales_Block_Order_View {

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('retailon/sales/order/view.phtml');

        if(!$this->isMainOrder()){
            $orderId = Mage::registry('current_order')->getIncrementId();
            $orderIdStr = $orderId.'-%';
            // To get sub orders
            $orders = Mage::getResourceModel('sales/order_collection')
                ->addAttributeToSelect('*')
                ->joinAttribute('shipping_firstname', 'order_address/firstname', 'shipping_address_id', null, 'left')
                ->joinAttribute('shipping_lastname', 'order_address/lastname', 'shipping_address_id', null, 'left')
                ->addAttributeToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomer()->getId())
                ->addAttributeToFilter('state', array('in' => Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates()))
                ->addAttributeToSort('created_at', 'desc')
                ->addFieldToFilter('increment_id',array('like' => $orderIdStr))
                ->load()
            ;

            $this->setOrders($orders);
        }
    }

    /*
     * To check the order is main order or sub order
     */
    public function isMainOrder(){
        $orderId = Mage::registry('current_order')->getIncrementId();
        if(strpos($orderId,'sub') === false)
            return false;
        return true;
    }

    public function getViewUrl($order)
    {
        return $this->getUrl('sales/order/view', array('order_id' => $order->getId()));
    }

    public function getReorderUrl($order)
    {
        return $this->getUrl('sales/order/reorder', array('order_id' => $order->getId()));
    }

    public function getCancelUrl($order)
    {
        return $this->getUrl('marketplace/order/cancel', array('order_id' => $order->getId()));
    }

    public function getItemNames($order)
    {
        $items = $order->getItemsCollection();
        $names = '';
        foreach($items as $item)
        {
            $product = $item->getProduct();
            $names .= $product->getName().' ';
        }
        return $names;
    }

}