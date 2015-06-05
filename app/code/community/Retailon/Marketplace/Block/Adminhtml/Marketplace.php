<?php


class Retailon_Marketplace_Block_Adminhtml_Marketplace extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
        $this->_controller = "adminhtml_marketplace";
        $this->_blockGroup = "marketplace";
        $this->_headerText = Mage::helper("marketplace")->__("Marketplace Vendor Manager");
        $this->_addButton('btnAdd', array(
            'label' => Mage::helper('marketplace')->__('Add New Vendor'),
            'onclick' => "setLocation('" . $this->getUrl('adminhtml/permissions_user/new') . "')",
            'class' => 'addnew'
        ));
        parent::__construct();
        $this->_removeButton('add');
	}
}