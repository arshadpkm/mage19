<?php
/**
 * Created by PhpStorm.
 * User: Arshad <me@arshu.in>
 * Date: 5/26/2015
 * Time: 3:08 PM
 */


/**
 * Used in creating options for Admin Roles config value selection
 *
 */
class Retailon_Marketplace_Model_Adminroles {
	/**
	 * Options getter
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		// Load admin roles
		$roles = Mage::getModel( 'admin/roles' )->getCollection();
		$roles_array = array();
		foreach ( $roles as $role ) {
			$roles_array[] = array( 'value' => $role->getRoleId(), 'label' => $role->getRoleName() );
		}
		
		return $roles_array;
	}

	/**
	 * Get options in "key-value" format
	 *
	 * @return array
	 */
	public function toArray()
	{
		// Load admin roles
		$roles = Mage::getModel( 'admin/roles' )->getCollection();
		$roles_array = array();
		foreach ( $roles as $role ) {
			$roles_array[ $role->getRoleId() ] = $role->getRoleName();
		}
		
		return $roles_array;
	}
}
?>