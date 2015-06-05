<?php
/**
 * Created by PhpStorm.
 * User: Arshad M <me@arshu.in>
 * Date: 5/26/2015
 * Time: 3:08 PM
 */


class Retailon_Marketplace_Model_Productobserver extends Mage_Payment_Model_Method_Abstract {
	/**
	* Function to limit products based on users
	*/
	public function limitUsers( $observer ) {
		// Get current logged in user
		$current_user = Mage::getSingleton( 'admin/session' )->getUser();
		
		// Limit only for vendors
		if ( $current_user->getRole()->getRoleId() == Mage::getStoreConfig( 'marketplace/marketplace/vendors_role' ) ) {
			// Do the following only for catalog_product controller
			if ( Mage::app()->getFrontController()->getRequest()->getControllerName() == 'catalog_product' ) {
				// Get collection
				$event = $observer->getEvent();
				$collection = $event->getCollection();
				
				// Get product collection by this user
				$my_products = Mage::getModel( 'marketplace/marketplaceproducts' )
					->getCollection()
					->addFieldToSelect( 'product_id' )
					->addFieldToFilter( 'user_id', $current_user->getUserId() )
					->load();
				
				$my_product_array = array();
				foreach ( $my_products as $product ) {
					$my_product_array[] = $product->getProductId();
				}
				
				if ( count( $my_product_array ) == 0 )
					$my_product_array[] = -1;
				
				// Limit collection based on current user's products
				$collection->addAttributeToFilter( 'entity_id', array(
					'in' => array( $my_product_array )
				) );
				
				return $this;
			}
		}
	}
	
	/**
	* Function to assign a product ID to a user
	*/
	public function newProduct( $observer ) {
		// Get current user
		$current_user = Mage::getSingleton( 'admin/session' )->getUser();
		
		// Assign only for vendor
		if ( $current_user->getRole()->getRoleId() == Mage::getStoreConfig( 'marketplace/marketplace/vendors_role' ) ) {
			// Get the new product
			$product = $observer->getEvent()->getProduct();
			
			// Check if the product is aready assigned to this user (not a new product)
			$my_product = Mage::getModel( 'marketplace/marketplaceproducts' )
					->getCollection()
					->addFieldToSelect( 'product_id' )
					->addFieldToFilter( 'product_id', $product->getEntityId() )
					->addFieldToFilter( 'user_id', $current_user->getUserId() )
					->load();
			
			// Product does not exist for user, save it
			if ( $my_product->getSize() == 0 ) {
				// Assign product to user
				$now = Mage::getModel('core/date')->timestamp( time() );
				Mage::getModel( 'marketplace/marketplaceproducts' )
					->setProductId( $product->getEntityId() )
					->setUserId( $current_user->getUserId() )
					->setmarketplaceProductsDtime( date( 'Y-m-d H:i:s', $now ))
					->save();
			}
		}
	}
	
	/**
	* Function to check if a user has permission to edit a product
	*/
	public function editProduct( $observer ) {
		// Get current user
		$current_user = Mage::getSingleton( 'admin/session' )->getUser();
		
		// Check only for vendors
		if ( $current_user->getRole()->getRoleId() == Mage::getStoreConfig( 'marketplace/marketplace/vendors_role' ) ) {
			// Get the product
			$product = $observer->getEvent()->getProduct();
			
			// Check if the product is assigned to this user
			$my_product = Mage::getModel( 'marketplace/marketplaceproducts' )
					->getCollection()
					->addFieldToSelect( 'product_id' )
					->addFieldToFilter( 'product_id', $product->getEntityId() )
					->addFieldToFilter( 'user_id', $current_user->getUserId() )
					->load();
			
			// Check if product not found, if so redirect back
			if ( $my_product->getSize() == 0 )
				Mage::app()->getResponse()->setRedirect( Mage::helper( 'adminhtml' )->getUrl(  '*/catalog_product/index' ) );
		}
	}
	
	/**
	* Function to remove a product's ID from a user
	*/
	public function deleteProduct( $observer ) {
		// Get the product
		$product = $observer->getEvent()->getProduct();
		
		// Get current user
		$current_user = Mage::getSingleton( 'admin/session' )->getUser();
		
		// Check if the product is assigned to this user
		$my_product = Mage::getModel( 'marketplace/marketplaceproducts' )
				->getCollection()
				->addFieldToSelect( '*' )
				->addFieldToFilter( 'product_id', $product->getEntityId() )
				->addFieldToFilter( 'user_id', $current_user->getUserId() )
				->load();
		
		// Check if product found, if so, delete its entry
		if ( $my_product->getSize() > 0 ) {
			foreach ( $my_product as $_product ) {
				Mage::getModel( 'marketplace/marketplaceproducts' )
					->setmarketplaceProductId( $_product->getmarketplaceProductId() )
					->delete();
			}
		}
	}
}
?>