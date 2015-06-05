<?php
/**
 * Created by PhpStorm.
 * User: Arshad <me@arshu.in>
 * Date: 5/26/2015
 * Time: 3:08 PM
 */
class Retailon_Marketplace_Model_Orderobserver extends Mage_Payment_Model_Method_Abstract {
	/**
	* Function to send an email to vendors when an order is placed
	*/
    private static $_handelFirstOrder = 1;
    private static $orderId = 1;

    /*
     * Write code here to perfoem action after canceling a order
     */
    public function afterOrderCancel($observer){
        // Edit or add yu code here
        $order = $observer->getEvent()->getOrder();
        Mage::log('Order number '.$order->getId().' has been canceled',null,'orderCancel.log');
    }

	public function orderSaved( $observer ) {
		// Check whether to notify vendors
		if ( Mage::getStoreConfig( 'marketplace/marketplace/notify_vendors' ) ) {
			// Get order and check if its status is matches the settings
			$order = $observer->getEvent()->getOrder();
//            Mage::log($order->getIsSingleOrder(),null,'single.log');

            if(self::$_handelFirstOrder > 1){
                return $this;
            }
            self::$_handelFirstOrder++;

            $items = $order->getItemsCollection();

            if(!$order->getIsSingleOrder() && count($items) > 1){
//                Mage::log('----------before----------------',null,'order.log');
//                Mage::log($order->debug(),null,'order.log');
//                Mage::log('----------after----------------',null,'order.log');

//                Mage::log('count '.count($items),null,'item.log');

                    foreach ( $items as $item ) {
//                        Mage::log('----------before item----------------',null,'item.log');
//                        Mage::log($item->debug(),null,'item.log');
//                        Mage::log('----------after item-----------------',null,'item.log');


                        if( $item->getProductType() == 'simple' ){

                            $singleOrder = Mage::getModel('marketplace/singleorder');
                            $singleOrder->setCustomer($order->getCustomerId());
                            $singleOrder->setShippingMethod($order->getShippingMethod());
                            $payment = $order->getPayment();
                            $singleOrder->setPaymentMethod($payment->getMethodInstance()->getCode());
                            $singleOrder->setOrderId($order->getIncrementId().'-sub-'.self::$orderId++);

                            $productOptions = $item->getProductOptions();
                            $infoBuyRequest = $productOptions['info_buyRequest'];

                            if($infoBuyRequest['options'])
                                $products = array(
                                    array(
                                        'product' => $item->getProductId(),
                                        'options' => $infoBuyRequest['options'],
                                        'qty'     => $item->getQtyOrdered()
                                    )
                                );
                            elseif($infoBuyRequest['super_attribute'])
                                $products = array(
                                    array(
                                        'product' => $item->getProductId(),
                                        'options' => $infoBuyRequest['super_attribute'],
                                        'qty'     => $item->getQtyOrdered()
                                    )
                                );
                            else
                                $products = array(
                                    array(
                                        'product' => $item->getProductId(),
                                        'qty' => $item->getQtyOrdered()
                                    )
                                );

                            if($products){
                                $singleOrder->createOrder($products);
                                $singleOrder->saveVendor($item->getProductId());
                            }
                        }

                    }
            }

			if ( $order->getStatus() == Mage::getStoreConfig( 'marketplace/marketplace/notify_order_status' ) )
				$this->notifyVendors( $order );
		}
        return $this;
	}

    /*
     * To process the order
     *
     * @param observer
     * @return order
     */
    private function createOrders($observer){
        $mage_order = $observer->getEvent()->getOrder();
        $items = $mage_order->getItemsCollection();
        $quote = $mage_order->getQuote();
        $orders = array();
        $orderIds = array();
        foreach ( $items as $item ) {
            $order = $this->_prepareOrder($quote,$item);

            $orders[] = $order;

            Mage::dispatchEvent(
                'checkout_marketplace_create_orders_single',
                array('order'=>$order)
            );
        }
        foreach ($orders as $order) {
            $order->place();
            $order->save();
            if ($order->getCanSendNewEmailFlag()){
                $order->sendNewOrderEmail();
            }
            $orderIds[$order->getId()] = $order->getIncrementId();
        }

        Mage::getSingleton('core/session')->setOrderIds($orderIds);
        Mage::getSingleton('checkout/session')->setLastQuoteId($quote->getId());

       // $quote->setIsActive(false)->save();

        Mage::dispatchEvent('checkout_submit_all_after', array('orders' => $orders, 'quote' => $quote));

    }

    /*
     * Prepare single order
     *
     * @param item
     * @return single order
     */
    private function _prepareOrder($quote,$item){

        $order = Mage::getModel('sales/order');

        $quote->unsReservedOrderId();
        $quote->reserveOrderId();
        $quote->collectTotals();

        $order->setIncrementId($quote->getReservedOrderId())
            ->setStoreId($quote->getStoreId())
            ->setQuoteId($quote->getId())
            ->setQuote($quote)
            ->setCustomer($quote->getCustomer());
        $convertQuote = Mage::getSingleton('sales/convert_quote');
        $order->setBillingAddress(
            $convertQuote->addressToOrderAddress($quote->getBillingAddress())
        );
        $order->setShippingAddress($convertQuote->addressToOrderAddress($quote->getShippingAddress()));

        $order->setPayment($convertQuote->paymentToOrderPayment($quote->getPayment()));
        if (Mage::app()->getStore()->roundPrice($quote->getGrandTotal()) == 0) {
            $order->getPayment()->setMethod('free');
        }

        $order->addItem($item);

        return $order;
    }
	
	/*
	 * Notifies vendors of an order
	 *
	 * @param $object
	 * @return void
	 */
	private function notifyVendors( $order ) {
		$vendors = array();
		
		// Get items in order, and split it based on vendors
		$items = $order->getItemsCollection();
		foreach ( $items as $item ) {
			// Get vendor for this item
			$product_id = $item->getProductId();
			$vendor = $my_product = Mage::getModel( 'marketplace/marketplaceproducts' )
				->getCollection()
				->addFieldToSelect( 'user_id' )
				->addFieldToFilter( 'product_id', $product_id )
				->load();
			
			// Check if vendor found
			if ( $vendor->getSize() > 0 ) {
				$vendor = $vendor->getFirstItem();
				$vendor_id = $vendor->getUserId();
				
				// Add vendor to array
				if ( ! isset( $vendors[ $vendor_id ] ) )
					$vendors[ $vendor_id ]['products'] = array( $product_id => $item->getQtyOrdered() );
				else
					$vendors[ $vendor_id ]['products'][ $product_id ] = $item->getQtyOrdered();
			}
		}
		
		// Check for vendors, and send emails
		if ( count( $vendors ) > 0 ) {
			foreach ( $vendors as $key => $vendor ) {
				$this->emailVendor( array( $key => $vendor ), $order );
			}
		}
	}
	
	/*
	 * Sends email to vendor
	 *
	 * @param $array
	 * @param $object
	 * @return void
	 */
	private function emailVendor( $vendor, $order ) {
		$email_html = '';
		$vendor_id = key( $vendor );
		$products = $vendor[ $vendor_id ]['products'];
		
		// Get vendor information
		$vendor = Mage::getModel( 'admin/user' )->load( $vendor_id );
		
		// Traverse products and build HTML email
		foreach ( $products as $product_id => $qty ) {
			$_product = Mage::getModel( 'catalog/product' )->load( $product_id );
			
			$email_html .= '<tr><td valign="top" style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA;">'. $_product->getName() .' ( '. $_product->getSku() .' )</td>';
			$email_html .= '<td align="center" valign="top" style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA; border-right:1px solid #EAEAEA;">'. number_format( $qty, 2 ) .'</td></tr>';
		}
		
		// Load template and send email
		if ( $email_html != '' ) {
			// Get vendor name and email
			$to_email = $vendor->getEmail();
			$to_name = $vendor->getFirstname() . ' ' . $vendor->getLastname();
			
			// Check if template is set, otherwise use default template
			if ( is_numeric( Mage::getStoreConfig( 'marketplace/marketplace/email_template' ) ) )
				$email_template = Mage::getModel( 'core/email_template' )->load( Mage::getStoreConfig( 'marketplace/marketplace/email_template' ) );
			else
				$email_template = Mage::getModel( 'core/email_template' )->loadDefault( 'retailon_marketplace_email' );
			
			try {
				/*
				Note: We get the processed email template and subject and send it manually
				to counter a problem of the transactional email not sending (for some weird reason!)
				i.e: $email_template->send( $to_email, $to_name, array( 'order' => $order, 'store' => Mage::app()->getStore(), 'items_html' => $email_html ) ); doesn't work!
				*/
				$email_content = $email_template->getProcessedTemplate( array( 'order' => $order, 'store' => Mage::app()->getStore(), 'items_html' => $email_html ) );
				$email_subject = $email_template->getProcessedTemplateSubject( array( 'order' => $order, 'store' => Mage::app()->getStore(), 'items_html' => $email_html ) );
				
				$mail = Mage::getModel( 'core/email' );
				$mail->setToName( $to_name );
				$mail->setToEmail( $to_email );
				$mail->setBody( $email_content );
				$mail->setSubject( $email_subject );
				$mail->setType( 'html' );
				if ( Mage::getStoreConfig( 'marketplace/marketplace/email_from_name' ) != '' )
					$mail->setFromName( Mage::getStoreConfig( 'marketplace/marketplace/email_from_name' ) );
				if ( Mage::getStoreConfig( 'marketplace/marketplace/email_from' ) != '' )
					$mail->setFromEmail( Mage::getStoreConfig( 'marketplace/marketplace/email_from' ) );

				$mail->send();
			}
			catch( Exception $e ) {}
		}
	}
}
?>