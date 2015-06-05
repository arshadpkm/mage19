<?php
class Retailon_Vendor_Adminhtml_VendorbackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Manage Vendor"));
	   $this->renderLayout();
    }
}