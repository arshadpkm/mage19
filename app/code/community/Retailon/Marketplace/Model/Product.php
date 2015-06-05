<?php
/**
 * Created by PhpStorm.
 * User: Arshad <me@arshu.in>
 * Date: 5/26/2015
 * Time: 3:08 PM
 */


class Retailon_Marketplace_Model_Product extends Mage_Catalog_Model_Product {
	/**
	 * Gets a product's associated vendor's ID
	 * @return int
	 */
	public function getVendorId() {
		// Get vendor ID based on product ID
		$vendor = Mage::getModel( 'marketplace/marketplaceproducts' )
					->getCollection()
					->addFieldToSelect( 'user_id' )
					->addFieldToFilter( 'product_id', $this->getEntityId() )
					->load();

		// Check if we have a vendor
		if ( $vendor->getSize() == 0 )
			return -1;
		elseif ( intval( $vendor->getFirstItem()->getUserId() ) > 0 )
			return intval( $vendor->getFirstItem()->getUserId() );
		else
			return -1;
	}

	/**
	 * Gets a products vendor details
	 * @return object|boolean
	 */
	public function getVendor() {
		// Get the vendor's ID
		$vendor_id = $this->getVendorId();

		// Check if we have a vendor
		if ( $vendor_id > 0 ) {
			$vendor = Mage::getModel( 'admin/user' )
						->getCollection()
						->addFieldToFilter( 'user_id', $vendor_id )
						->load();

			// Double check if we found a user
			if ( $vendor->getSize() == 0 )
				return false;

			return $vendor->getFirstItem();
		}
		// No vendor found
		else
			return false;
	}
}
?>