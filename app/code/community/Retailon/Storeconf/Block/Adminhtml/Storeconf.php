<?php


class Retailon_Storeconf_Block_Adminhtml_Storeconf extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_storeconf";
	$this->_blockGroup = "storeconf";
	$this->_headerText = Mage::helper("storeconf")->__("All Stores");
	$this->_addButton('btnAdd', array(
        'label' => Mage::helper('storeconf')->__('Add New Store'),
        'onclick' => "setLocation('" . $this->getUrl('admin_storeconf/adminhtml_store/index') . "')",
        'class' => 'addnew'
    ));
	parent::__construct();
	$this->_removeButton('add');

	}

}