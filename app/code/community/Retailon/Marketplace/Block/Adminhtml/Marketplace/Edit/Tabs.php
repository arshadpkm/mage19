<?php
class Retailon_Marketplace_Block_Adminhtml_Marketplace_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("marketplace_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("marketplace")->__("Manage Vendor"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("marketplace")->__("Vendor Details"),
				"title" => Mage::helper("marketplace")->__("Vendor Details"),
				"content" => $this->getLayout()->createBlock("marketplace/adminhtml_marketplace_edit_tab_form")->toHtml(),
				));

				return parent::_beforeToHtml();
		}

}
