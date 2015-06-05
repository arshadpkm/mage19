<?php
class Retailon_Storeconf_Block_Adminhtml_Storeconf_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("storeconf_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("storeconf")->__("Vendor Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("storeconf")->__("Vendor Information"),
				"title" => Mage::helper("storeconf")->__("Vendor Information"),
				"content" => $this->getLayout()->createBlock("storeconf/adminhtml_storeconf_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
